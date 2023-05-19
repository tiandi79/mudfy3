<?php
/**
*  跟随
*
*/
namespace cmds\std;

use std\msg;

class follow
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null)
    {
        $me = $ob->body;

        if (!isset($arg)) {
            $ob->ssend('指令格式：follow <生物ID>');
            return false;
        }

        if ($arg == "none") {
            if ($me->query_leader()) {
                $me->del_leader();
                $ob->ssend('OK.');
                return true;
            } else {
                $ob->ssend('你现在并没有跟随任何人。');
                return true;
            }
        }
        
        $who = $me->is_environment($arg);

        if (!$who) {
            $ob->ssend('这里没有' . $arg . '。');
            return true;
        }

        if (!$who->is_character()) {
            $ob->ssend('什麽？跟随....' . $arg . '。');
            return true;
        }

        if (!$who == $me) {
            $ob->ssend('跟随自己？');
            return true;
        }

        $me->set_leader($who);
	    msg::message('vision', '$N决定开始跟随$n一起行动。', $me, $who);
    }

    public function help() 
    {
        $ret = "指令格式 : follow [<生物>|none]<br>这个指令让你能跟随某人或生物。如果输入 follow none 则停止跟随。";
        return $ret;
    }
}
