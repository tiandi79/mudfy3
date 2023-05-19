<?php
/**
*  给
*
*/
namespace cmds\std;

use std\msg;

class give
{
    function __construct()
    {
    }

    public function do_cmd($ob, $nums = null, $item = null, $to = 'to', $target = null)
    {
        $me = $ob->body;

        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还未完成，不能进行此操作。');
            return false;
        }

        $arg = trim($nums . ' ' . $item . ' ' . $to . ' ' . $target);
        $args = explode(' ', $arg);

        if (count($args) == 4) {
            $amount = $args[0];
            $item = $args[1];
            $target = $args[3];

            if (!is_numeric($amount)) {
                $ob->ssend('数量必须是数字。');
                return false;
            }

            if (!$who = $me->is_environment($target)) {
                $ob->ssend('这里没有这个人。');
                return false;
            }
            
            if (!$obj = $me->is_carry($item)) {
                $ob->ssend('你身上没有这样东西。');
                return false;
            }

            if ($obj->query('no_drop') != null) {
                $ob->ssend('这样东西不能随便给人。');
                return false;
            }

            if (!$obj->query_amount()) {
                $ob->ssend('这样东西不能被分开给人。');
                return false;
            }
            
            if ($amount < 1) {
                $ob->ssend('数量至少是一个。');
                return false;
            }

            if ($amount > $obj->query_amount()) {
                $ob->ssend('你没有那么多的' . $obj->query('name') . '。');
                return false;
            }

            if ($amount == $obj->query_amount()) 
                return $this->do_give($me, $obj, $who);
            else {
                $obj->set_amount($obj->query_amount() - $amount);
                global $OBJECT;
                $obj2 = $OBJECT->create_objects($obj->get_basename(1));  
			    $obj2->set_amount($amount);
			    return $this->do_give($me, $obj2, $who);
            }

        } elseif (count($args) == 3) {
            $target = $args[2];
            if (!$who = $me->is_environment($target)) {
                $ob->ssend('这里没有这个人。');
                return false;
            }
            
            if ($args[0] == 'all') {
                $objs = $me->all_inventory();
                foreach ($objs as $v) {
                    $this->do_give($me, $v, $who);
                }
                return true;
            }

            $item = $args[0];
            if (!$obj = $me->is_carry($item)) {
                $ob->ssend('你身上没有这样东西。');
                return false;
            } else {
                return $this->do_give($me, $obj, $who);
            }
        } else {
            $ob->ssend('指令格式 : give [数量] <物品名称> to <某人>');
            return false;
        }
    }

    public function do_give($me, $obj, $who)
    {
        $ob = $me->get_conn();
        if ($obj->query('no_drop') != null) {
            $ob->ssend('这样东西不能随便给人。');
            return false;
        }

        if ($obj->query('dynamic_quest') != null) {
            global $TASK_D;
            return $TASK_D->quest_reward($me, $who, $obj);
        }

        if (!$who->is_player() && (!method_exists($who, 'accept_object') || !$who->accept_object($me, $obj))) {
            $ob->ssend('你只能把东西送给其他玩家操纵的人物。');
            return true;
        }

        if (!$who->is_player() && !$who->query('can_carry')) {
            $ob->ssend('你拿出' . $obj->query('name') . '给' . $who->query('name') . '。');
            $obj->destruct();
            return true;
        } elseif ($obj->move($who)) {
            msg::message('vision', '$N给了$n一' . $obj->query('unit') . $obj->query('name') . '。', $me, $who);
            return true;
        } else
            return false;
    }

    public function help() 
    {
        $ret = "指令格式 : give [数量] <物品名称> to <某人><br>这个指令可以让你将某样物品给别人, 当然, 首先你要拥有这样物品.";
        return $ret;
    }
}
