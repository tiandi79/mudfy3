<?php
/**
*  放
*
*/
namespace cmds\std;

use std\msg;

class put
{
    function __construct()
    {
    }

    public function do_cmd($ob, $cmd1 = null, $cmd2 = null, $cmd3 = null, $cmd4 = null, $cmd5 = null)
    {
        $arg = trim($cmd1 . ' ' . $cmd2 . ' ' . $cmd3 . ' ' . $cmd4 . ' ' . $cmd5);
        if (!isset($arg)) {
            $ob->ssend('你要将什麽东西放进哪里？');
            return false;
        }

        $me = $ob->body;
        if ($me->is_busy) {
            $ob->ssend('你上一个动作还没有完成！');
            return false;
        }
        
        $p = '/(.*)in(.*)/';
        preg_match_all($p, $arg, $matches);

        if (isset($matches[0][0])) {        
            $putid = trim($matches[1][0]);
            $toid = trim($matches[2][0]);
            if ((!$me->is_environment($toid) && !$me->is_carry($toid))|| $toid == $me->id) {
                $ob->ssend('你找不到 ' . $toid . ' 这样东西。');
                return false;
            }
            $target = $me->is_environment($toid);
            if (!$target)
                $target = $me->is_carry($toid);
            if ($target->is_character() && !$target->is_corpse()) {
                $ob->ssend('你要将什麽东西放进哪里？');
                return false;
            }

            if ($target->is_close()) {
                $ob->ssend('你要先把' . $target->query('name') . '打开。');
                return false;
            }

            $puts = explode(' ', $putid);
            if (count($puts) > 2) {
                $ob->ssend('格式：put [数量] <物品> in <容器>');
                return false;
            }

            /* put 2 coin 这种格式 */
            if (count($puts) == 2 && is_numeric($puts[0])) {
               $amount = $puts[0];
               $objid = $puts[1];
               $obj = null;
               if ($me->is_carry($objid))
                   $obj = $me->is_carry($objid);
               else {
                   $ob->ssend('你身上没有这样东西。');
                   return false;
               }

               if (!$obj->query_amount()) {
                   $ob->ssend($obj->query('name') . '不能被分开放。');
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
                   $this->ready_to_put($me, $target, $obj, $amount);
                   return true;
               } else {
                   $obj->set_amount($obj->query_amount() - $amount);
                   global $OBJECT;
                   $obj2 = $OBJECT->create_objects($obj->get_basename(1));
                   $obj2->set_temp('no_combine', 1);
                   $obj2->move($me);
                   $obj2->del_temp('no_combine');
                   $obj2->set_amount($amount);
                   if ($me->is_fighting()) 
                       $me->start_busy(3);
                   $this->ready_to_put($me, $target, $obj2, $amount);
                   return true;
                }
            }

            if ($puts[0] == 'all') {
                if ($me->is_fighting())	{
                    $ob->ssend('你还在战斗中！只能一次放一样。');
                    return false;
                }

                if (!$target->query_max_encumbrance())	{
                    $ob->ssend('那不是容器。');
                    return false;
                }

                $inv = $me->all_inventory();
                if (count($inv) < 1) {
                    $ob->ssend('你身上没有任何东西。');
                    return false;
                }
              
                foreach ($inv as $v) {
                    if ($v->is_character() || $v->query("no_drop") != null) 
                       continue;
                    $this->ready_to_put($me, $target, $v);
                }
                $ob->ssend('OK。');
                return false;
            }

            if ($me->is_carry($puts[0])) {
                $obj = $me->is_carry($puts[0]);
                if ($obj->query('no_drop') != null) {
                    $ob->ssend('这个东西只能你自己拿着。');
                    return false;
                }
                if ($obj->query('equipped') != null) {
                    $ob->ssend('装备着的东西必须先脱下来。');
                    return false;
                }
                $this->ready_to_put($me, $target, $obj);

            }
            else {
                $ob->ssend('你身上没有这样东西。');
                return false;
            }
        } else {
            $ob->ssend('你要将什麽东西放进哪里？');
            return false;
        }
    }

    public function ready_to_put($me, $target, $obj, $amount = null)
    {
        if ($obj == null || $obj == $me || $obj == $target)
            return false;

        global $CHINESE_D;
        if (isset($amount)) {
            $unit = $obj->query('base_unit');
            $num = $CHINESE_D->chinese_number($amount);
        } else {
            $unit = $obj->query('unit');
            $num = '一';
        }

	    if ($obj->move($target)) {
            if ($me->is_fighting()) 
                $me->start_busy(1);

            switch ($target->query('prep')) {
                case "on":
                    $prep = "放在" . $target->query('name') . "上";
                    break;
                case "under":
                    $prep = "放在" . $target->query('name') . "下";
                    break;
                case "behind":
                    $prep = "放在" . $target->query('name') . "后面";
                    break;
                case "inside":
                    $prep = "放在" . $target->query('name') . "里面";
                    break;
                default:
                    $prep = "放在" . $target->query('name') . "里面";
                    break;
           }
           msg::message('vision', '$N将' . $num . $unit . '$n' . $prep . '。', $me, $obj);
        }
    }

    public function help() 
    {
        $ret = "指令格式 : put <物品名称> in <某容器><br>这个指令可以让你将某样物品放进一个容器，当然，首先你要拥有这样物品。";
        return $ret;
    }
}
