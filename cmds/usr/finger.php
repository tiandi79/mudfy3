<?php
/**
*  用户退出
* 
*/

namespace cmds\usr;

class finger
{
    function __construct() 
    {

    }

    public function do_cmd($ob, $arg = null)
    {
        global $GAME;
        $me = $ob->body;
        if ($arg == null) {
            $ob->ssend('指令格式 : finger [用户ID]。');
            return true;
        }

        if ($me->query('sen') < 50) {
            $ob->ssend('你的精神无法集中。');
            return true;
        }

        $me->receive_damage("sen", 50);
        global $FINGER_D;
        $ob->ssend($FINGER_D->finger_user($ob, $arg, ($me->wizardp() || $arg == $me->query("id"))));
        return true;
    }

    public function help() 
    {
        $ret = "指令格式 : finger [使用者姓名]<br>显示有关某个玩家的连线, 权限等资料.";
        return $ret;
    }
}
