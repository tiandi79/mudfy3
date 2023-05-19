<?php
/**
*  说话
*
*/
namespace cmds\std;

use std\msg;

class say
{
    function __construct()
    {   
    }

    public function do_cmd($ob, $arg = null)
    {
        $me = $ob->body;

        if ($arg == null) {
            msg::message('vision', '$N自言自语不知道在说些什麽。', $me);
            return false;
        }
         
        if ($me->query('kee') < $me->query('max_kee') / 5) {
            $arg = $this->low_kee_say($arg);
        }

        msg::message('vision', 'CYN$N说道：' . $arg . 'NOR', $me);
    }

    private function low_kee_say($arg)
    {   
        $len = mb_strlen($arg);
        $str = '...';
        $final_str = '';

        for ($i = 0; $i < $len; $i++) {
            if (rand(0, 2) == 0)
                $final_str .= mb_substr($arg, $i, 1) . $str;
            else
                $final_str .= mb_substr($arg, $i, 1);
        }
        return $final_str . $str;
    }

    public function help() 
    {
        $ret = "指令格式: say <讯息><br>说话，所有跟你在同一个房间的人都会听到你说的话。";
        return $ret;
    }
}
