<?php
/**
*  smash
*  
*/
namespace cmds\wiz;

use std\msg;

class smash
{
    function __construct() 
    {

    }

    public function do_cmd($ob, $arg = null) 
    {
        if (!$ob->body->wizardp()) {
            $ob->ssend("什么？");
            return;
        }

        if (null == $arg)
            $ob->ssend("指令格式: smash <某人>");
        else {
            $me = $ob->body;
            if (!$me->is_environment($arg))
                $ob->ssend("找不到这个生物。");
            else {
                $target = $me->is_environment($arg);
                if ($target == $me) {
                    $ob->ssend('你还是自杀来得快。');
                } elseif ($target->living()) {
                    msg::message('vision', '$N手一挥，一道闪电从天而降，将$n化为齑粉！！', $me, $target);
                    $target->die();
                }
                else
                    $ob->ssend("这个东西不是生物。");
            }
        }
    }

    public function help() 
    {
        $ret = "指令格式: smash <某人>hehehehehe...........";
        return $ret;
    }
}