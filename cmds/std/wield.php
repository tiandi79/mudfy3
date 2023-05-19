<?php
/**
*  装备
*
*/
namespace cmds\std;

use std\msg;

class wield
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null)
    {
        if (!isset($arg)) {
            $ob->ssend('你要装备什麽武器？');
            return false;
        }

        $me = $ob->body;
        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成！');
            return false;
        }

        if ($me->query_temp('weapon') != null) {
            $ob->ssend('你已经装备着武器了。');
            return false;
        }   
        
        if ($arg == 'all') {
            $objs = $me->all_inventory();
            foreach ($objs as $k => $v) {
                if ($v->query('equipped' != null))
                    continue;
                $this->ready_to_wield($me, $v);
            }
            $ob->ssend('OK.');
            return true;
        }

        if (!$me->is_carry($arg)) {
            $ob->ssend('你身上没有这样东西。');
        }
        else {
            $obj = $me->is_carry($arg);
            $this->ready_to_wield($me, $obj);
        }
    }

    private function ready_to_wield($me, $obj)
    {
        if ($me->query_temp('weapon') != null)
            return false;

        if ($me->equip($obj, 'wield')) {
            if ($obj->query('wield_msg') != null)
                msg::message('vision', $obj->query('wield_msg'), $me, $obj);
            else
                msg::message('vision', '$N装备$n作武器。', $me, $obj);
            return true;
        }
        else { 
            return false;
        }
    }

    public function help() 
    {
        $ret = "指令格式：wield <装备名称><br>这个指令让你装备某件物品作武器, 你必需要拥有这样物品.";
        return $ret;
    }
}
