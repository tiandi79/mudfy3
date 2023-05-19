<?php
/**
*  中止战斗
*
*/

namespace cmds\wiz;

use std\msg;

class halt
{
    function __construct() 
    {

    }

    public function do_cmd($ob, $arg = null) 
    {
        $me = $ob->body;
        if (!$me->wizardp()) {
            $ob->ssend("什么？");
            return;
        }

        if (!$me->is_fighting()) {
            $ob->ssend("你现在并没有在战斗。");
            return;
        }

    	$me->remove_all_killer();
	    msg::message('vision', '$N用巫师的神力停止了这场打斗。', $me);
    }

    public function help() 
    {
        $ret = "指令格式: halt<br>可以停止所有与你有关的战斗。";
        return $ret;
    }
}
