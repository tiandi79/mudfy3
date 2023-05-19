<?php
/**
*  task
*
*/
namespace cmds\std;

class task
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null)
    {
        $me = $ob->body;
        $me->add('sen', -5);
        $output =  'HIR◎  风云Ⅲ使命榜 NOR<br>';
        $output .= '———————————————————————————<br>';
        global $TASK_D;
        $output .= $TASK_D->dyn_quest_list();
        $output .= '———————————————————————————<br>';
        $ob->ssend($output);
        return true;
    }

    public function help() 
    {
        $ret = "指令格式: tasks<br>这个指令是用来得知目前的所有使命.";
        return $ret;
    }
}
