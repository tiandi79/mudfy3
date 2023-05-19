<?php
/**
*  穿戴
*
*/
namespace cmds\std;

use std\msg;

class wear
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null)
    {
        if (!isset($arg)) {
            $ob->ssend('你要穿戴什麽防具？');
            return false;
        }

        $me = $ob->body;
        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成！');
            return false;
        }
        
        if ($arg == 'all') {
            $objs = $me->all_inventory();
            foreach ($objs as $k => $v) {
                if ($v->query('equipped' != null))
                    continue;
                $this->ready_to_wear($me, $v);
            }
            $ob->ssend('OK.');
            return true;
        }

        if (!$me->is_carry($arg)) {
            $ob->ssend('你身上没有这样东西。');
        }
        else {
            $obj = $me->is_carry($arg);
            if ($me->query_temp('armor/' . $obj->query('type')) != null) {
                $ob->ssend('你已经穿戴者同类防具了。');
                return false;
            }   
            $this->ready_to_wear($me, $obj);
        }
    }

    private function ready_to_wear($me, $obj)
    {
        if ($obj->query("female_only") && $me->query('gender') != '女性') {
            $me->get_conn()->ssend('这是女人的衣衫，你一个大男人也想穿，羞也不羞？');
            return false;
        }

        if ($me->query_temp('armor/' . $obj->type) != null)
            return false;

        if ($me->equip($obj, 'wear')) {
            if ($obj->query('wear_msg') != null)
                msg::message('vision', $obj->query('wear_msg'), $me, $obj);
            else {
                switch ($obj->query('type')) {
                    case 'cloth':
                    case 'armor':
                    case 'boots':
                        msg::message('vision', '$N穿上了一' . $obj->query('unit') . '$n。', $me, $obj);
                        break;
                    case 'head':
                    case 'ring':
                    case 'wrists':
                    case 'neck':
                    case 'hands':
                        msg::message('vision', '$N戴上了一' . $obj->query('unit') . '$n。', $me, $obj);
                        break;
                    case 'waist':
                        msg::message('vision', '$N将一' . $obj->query('unit') . '$n绑在了腰间。', $me, $obj);
                        break;
                    default:
                        msg::message('vision', '$N装备$n。', $me, $obj);
                       
                }

            }
            return true;
        }
        else 
            return false;
    }

    public function help() 
    {
        $ret = "指令格式：wear <装备名称><br>这个指令让你装备某件物品作武器, 你必需要拥有这样物品.";
        return $ret;
    }
}
