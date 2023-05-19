<?php
/**
*  丢
*
*/
namespace cmds\std;

use std\msg;

class drop
{
    function __construct()
    {
    }

    public function do_cmd($ob, $cmd1 = null, $cmd2 = null)
    {
        $arg = trim($cmd1 . ' ' . $cmd2);
        if (null == $arg) {
            $ob->ssend('你要丢弃什麽东西？');
            return false;
        }

        $drops = explode(' ', $arg);
        if (count($drops) > 2) {
            $ob->ssend('格式：drop [数量] <物品id>');
            return false;
        }
        
        $me = $ob->body;

        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还未完成，不能进行此操作。');
            return false;
        }

        /* drop 2 coin 这种格式 */
        if (count($drops) == 2 && is_numeric($drops[0])) {
            $amount = $drops[0];
            $objid = $drops[1];
            if (!$me->is_carry($objid)) {
                $ob->ssend('你身上没有这样东西。');
                return false;
            }

            $obj = $me->is_carry($objid);

            if ($obj->query('no_drop') != null) {
                $ob->ssend('这个东西不能丢弃。');
                return false;
            }

            if (!$obj->query_amount()) {
                $ob->ssend('这个东西不能分开丢弃。');
                return false;
            }

            if ($amount < 1) {
                $ob->ssend('东西的个数至少是一个。');
                return false;
            }

            if ($amount > $obj->query_amount()) {
                $ob->ssend('你没有那麽多的' . $obj->query('name') . '。');
                return false;
            }
            elseif ($amount == $obj->query_amount()) {
                $this->ready_to_drop($me, $obj, $amount);
                return true;
            }
            else {
                $obj->set_amount($obj->query_amount() - $amount);
                global $OBJECT;
                $obj2 = $OBJECT->create_objects($obj->get_basename(1));
                $obj2->set_amount($amount);
                $this->ready_to_drop($me, $obj2, $amount);
                return true;
            }
        }
        
        if ($drops[0] == 'all') {
            $objs = $me->all_inventory();
            $flag = false;
            if ($objs) {
                foreach ($objs as $v) {
                    if ($this->ready_to_drop($me, $v))
                        $flag = true;
                }
            }
            $ob->ssend('OK.');
            return true;
        }

        if (!$me->is_carry($arg)) {
            $ob->ssend('你身上没有这个东西。');
            return false;
        } else {
            $obj = $me->is_carry($arg);
            $this->ready_to_drop($me, $obj);
            return true;
        }
    }
             
    public function ready_to_drop($me, $obj, $amount = null)
    {
        $ob = $me->get_conn();
        if ($obj->query('no_drop') != null) {
            $ob->ssend('这个东西不能丢弃。');
            return false;
        }

        if (null != $obj->query('equipped')) {
            //$ob->ssend('正穿着的装备不能丢弃。');
            //return false;
            $me->unequip($obj);
        }
        
        global $CHINESE_D;
        if (isset($amount)) {
            $unit = $obj->query('base_unit');
            $num = $CHINESE_D->chinese_number($amount);
        } else {
            $unit = $obj->query('unit');
            $num = '一';
        }

        $env = $me->get_env();

        if ($obj->move($env)) {
            if ($obj->is_character())
                msg::message('vision', '$N将$n从背上放了下来，躺在地上。', $me, $obj);
            else {
                msg::message('vision', '$N丢下' . $num . $unit . '$n。', $me, $obj);
                $me->save();
                if ($obj->query("value") < 4 && (null == $obj->query("dynamic_quest"))) {
                   $ob->ssend("因为这样东西并不值钱，所以人们并不会注意到它的存在。");
                   $obj->destruct();
                }
            }
            return true;
        }
    }

    public function help() 
    {
        $ret = "指令格式 : drop <物品名称><br>这个指令可以让你丢下你所携带的物品.";
        return $ret;
    }
}
