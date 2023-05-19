<?php
/**
*  拿
*
*/
namespace cmds\std;

use std\msg;

class get
{
    function __construct()
    {
    }

    public function do_cmd($ob, $cmd1 = null, $cmd2 = null, $cmd3 = null, $cmd4 = null, $cmd5 = null)
    {
        $arg = trim($cmd1 . ' ' . $cmd2 . ' ' . $cmd3 . ' ' . $cmd4 . ' ' . $cmd5);
        if (!isset($arg)) {
            $ob->ssend('你要捡起什麽东西？');
            return false;
        }

        $me = $ob->body;
        if ($me->is_busy) {
            $ob->ssend('你上一个动作还没有完成！');
            return false;
        }
        
        $p = '/(.*)from(.*)/';
        preg_match_all($p, $arg, $matches);

        if (isset($matches[0][0])) {            
            $getid = trim($matches[1][0]);
            $fromid = trim($matches[2][0]);
            if ((!$me->is_environment($fromid) && !$me->is_carry($fromid)) || $fromid == $me->id) {
                $ob->ssend('你找不到 ' . $fromid . ' 这样东西。');
                return false;
            }
            $env = $me->is_environment($fromid);
            if (!$env)
                $env = $me->is_carry($fromid);
            if (!$me->wizardp() && $env->is_character() && !$env->is_corpse()) {
                $ob->ssend('你的管理等级必须比对方高，才能搜身。');
                return false;
            }
        } else {
            $env = $me->get_env();
            $getid = $arg;
        }
        
        if ($env->is_close()) {
            $ob->ssend('你要先把' . $env->query('name') . '打开。');
            return false;
        }

        $gets = explode(' ', $getid);
        if (count($gets) > 2) {
            $ob->ssend('格式：get [数量] <物品id> [from 物品id]');
            return false;
        }
        
        /* get 2 coin 这种格式 */
        if (count($gets) == 2 && is_numeric($gets[0])) {
           $amount = $gets[0];
           $objid = $gets[1];
           $obj = null;
           if ($env->is_carry($objid))
               $obj = $env->is_carry($objid);
           else {
               $ob->ssend('这里没有这样东西。');
               return false;
           }

           if (!$obj->query_amount()) {
               $ob->ssend($obj->query('name') . '不能被分开拿走。');
               return false;
           }

           if ($amount < 1) {
               $ob->ssend('东西的个数至少是一个。');
               return false;
           }

           if ($amount > $obj->query_amount()) {
               $ob->ssend('这里没有那麽多的' . $obj->query('name') . '。');
               return false;
           }
            
           if ($amount == $obj->query_amount()) {
               $this->ready_to_get($me, $obj, $amount);
               return true;
           } else {
               $obj->set_amount($obj->query_amount() - $amount);
               global $OBJECT;
               $obj2 = $OBJECT->create_objects($obj->get_basename(1));
               $obj2->set_temp('no_combine', 1);
               $obj2->move($env);
               $obj2->del_temp('no_combine');
               $obj2->set_amount($amount);
               if ($me->is_fighting()) 
                   $me->start_busy(3);
               $this->ready_to_get($me, $obj2, $amount);
               return true;
            }
        }

        if ($gets[0] == 'all') {
            if ($me->is_fighting())	{
                $ob->ssend('你还在战斗中！只能一次拿一样。');
                return false;
            }

            if (!$env->query_max_encumbrance())	{
                $ob->ssend('那不是容器。');
                return false;
            }

		    $inv = $env->all_inventory();
		    if (count($inv) < 1) {
                $ob->ssend('那里面没有任何东西。');
                return false;
            }
      
            foreach ($inv as $v) {
			    if (($v->is_character() && (null == ($v->query("yes_carry")))) || $v->query("no_get") != null) 
                    continue;
			    $this->ready_to_get($me, $v);
            }
            $ob->ssend('OK。');
            return false;
        }

        if ($env->is_carry($gets[0])) {
            $obj = $env->is_carry($gets[0]);
            if ($obj->living() && (null == $obj->query("yes_carry"))) {
                $ob->ssend('你附近没有这样东西。');
                return false;
            }
            if ($obj->query('no_get') != null) {
                $ob->ssend('这个东西拿不起来。');
                return false;
            }
            $this->ready_to_get($me, $obj);

        }
        else {
            $ob->ssend('你附近没有这样东西。');
            return false;
        }
    }

    public function ready_to_get($me, $obj, $amount = null)
    {
        if ($obj == null || $obj == $me)
            return false;
        $old_env = $obj->get_env();
        if ($obj->is_character()  && !$obj->is_corpse() && $obj->query('yes_carry') == null) {
            $ob->ssend('你只能背负尸体。');
            return false;
        }

        $target = $me;
        $equipped = 0;
        if (null != $obj->query('equipped')) {
            $equipped = 1;
        }

        global $CHINESE_D;
        if (isset($amount)) {
            $unit = $obj->query('base_unit');
            $num = $CHINESE_D->chinese_number($amount);
        } else {
            $unit = $obj->query('unit');
            $num = '一';
        }

	    if ($obj->move($target)) {
		    if (null != $obj->query("no_transfer")) {
                $obj->set('no_drop', 1);
                $obj->set('no_get', 1);
            }

            if ($me->is_fighting()) 
                $me->start_busy(1);
		    if ($obj->is_character() && null == $obj->query("yes_carry")) {
			    msg::message('vision', '$N将$n扶了起来背在背上。', $me, $obj);
            }
		    else {
                if ($old_env == $me->get_env())
                    $prep =  "捡起";
                elseif ($old_env->is_character())  {
                    $prep =  "从" . $old_env->query('name') . "身上" . ($equipped ? "除下" : "搜出");
                }
                else {
                    switch ($old_env->query('prep')) {
                        case "on":
                            $prep = "从" . $old_env->query('name') . "上拿起";
                            break;
                        case "under":
                            $prep = "从" . $old_env->query('name') . "下拿出";
                            break;
                        case "behind":
                            $prep = "从" . $old_env->query('name') . "后拿出";
                            break;
                        case "inside":
                            $prep = "从" . $old_env->query('name') . "中拿出";
                            break;
                        default:
                            $prep = "从" . $old_env->query('name') . "中拿出";
                            break;
                    }
                }
                msg::message('vision', '$N' . $prep . $num . $unit . '$n。', $me, $obj);
		    }
        }
    }

    public function help() 
    {
        $ret = "指令格式 : get <物品名称> [from <容器名>]<br>这个指令可以让你捡起地上或容器内的某样物品.";
        return $ret;
    }
}
