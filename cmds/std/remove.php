<?php
/**
*  卸下防具
*
*/
namespace cmds\std;

use std\msg;

class remove
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null)
    {
        if (!isset($arg)) {
            $ob->ssend('你要卸下什麽防具？');
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
                if ($v->query('equipped' == null))
                    continue;
                $this->ready_to_remove($me, $v);
            }
            $ob->ssend('OK.');
            return true;
        }

        if (!$me->is_carry($arg)) {
            $ob->ssend('你身上没有这样东西。');
        }
        else {
            $obj = $me->is_carry($arg);
            if (null == $me->query_temp('armor/' . $obj->query('type'))) {
                $ob->ssend('你并没有穿戴这类防具。');
                return false;
            }             
            $this->ready_to_remove($me, $obj);
        }
    }

    private function ready_to_remove($me, $obj)
    {
        if ($me->unequip($obj, 'remove')) {
            if ($obj->query('remove_msg') != null)
                msg::message('vision', $obj->query('remove_msg'), $me, $obj);
            else
                msg::message('vision', '$N卸下了$n。', $me, $obj);
            return true;
        }
        else 
            return false;
    }

    public function help() 
    {
        $ret = "指令格式：remove <防具名称><br>这个指令让你卸下防具，你必需要拥有这样物品.";
        return $ret;
    }
}
