<?php
/**
*  卸下装备
*
*/
namespace cmds\std;

use std\msg;

class unwield
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null)
    {
        if (!isset($arg)) {
            $ob->ssend('你要卸下什麽武器？');
            return false;
        }

        $me = $ob->body;
        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成！');
            return false;
        }

        if (null == $me->query_temp('weapon')) {
            $ob->ssend('你并没有装备武器。');
            return false;
        }   
        
        if ($arg == 'all') {
            $objs = $me->all_inventory();
            foreach ($objs as $k => $v) {
                if ($v->query('equipped' == null))
                    continue;
                $this->ready_to_unwield($me, $v);
            }
            $ob->ssend('OK.');
            return true;
        }

        if (!$me->is_carry($arg)) {
            $ob->ssend('你身上没有这样东西。');
        }
        else {
            $obj = $me->is_carry($arg);
            $this->ready_to_unwield($me, $obj);
        }
    }

    private function ready_to_unwield($me, $obj)
    {
        if ($me->unequip($obj, 'unwield')) {
            if ($obj->query('unwield_msg') != null)
                msg::message('vision', $obj->query('unwield_msg'), $me, $obj);
            else
                msg::message('vision', '$N卸下了$n。', $me, $obj);
            return true;
        }
        else 
            return false;
    }

    public function help() 
    {
        $ret = "指令格式：unwield <装备名称><br>这个指令让你卸下武器, 你必需要拥有这样物品.";
        return $ret;
    }
}
