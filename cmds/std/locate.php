<?php
/**
*  locate
*
*/
namespace cmds\std;

use std\msg;

class locate
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null)
    {
        $me = $ob->body;
        
        if ($arg == null) {
            $ob->ssend('指令格式: locate <物品>');
            return true;
        }

        if ($me->query('sen') < 5) {
            $ob->ssend('你的神太差了！');
            return true;
        }   

        $me->add("sen", -5);

        global $TASK_D;
        $output = $TASK_D->locate_obj($me, $arg);
        if ($output == '') {
            $ob->ssend('确定不了' . $arg . '的大概位置。');
            return true;
        } else {
            $ob->ssend($output);
            return true;
        }
    }

    public function help() 
    {
        $ret = "这个指令是用来得知使命物品的大概位置。朝廷官员还可以用此指令察寻人物的大概位置。";
        return $ret;
    }
}
