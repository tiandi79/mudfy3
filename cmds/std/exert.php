<?php
/**
*  内功特殊招式
*
*/
namespace cmds\std;

use std\msg;

class exert
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null)
    {
        $me = $ob->body;
        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成，不能施用内功。');
            return false;
        }

        if (!isset($arg)) {
            $ob->ssend('你要用内功做什麽？');
            return false;
        }

        $enable_skill = $me->query_skill_mapped('force');
        global $GAMESKILLS;
        if (null == $enable_skill) {
            $ob->ssend('你请先用 enable 指令选择你要使用的外功。');
            return false;
        }
        else {
            $skill = $GAMESKILLS->get($enable_skill);
            if ($skill->exert_action($me, $arg)) {
                if (rand(0, 120) < $me->query_skill($enable_skill, 1)) {
                    $me->improve_skill($enable_skill, 1);
                }
                return true;
            }
        }       
        return false;
    }

    public function help() 
    {
        $ret = "指令格式：exert <功能名称><br>用内力进行一些特异功能，你必需要指定<功能名称>，<施用对象>则可有可无。在你使用某一种内功的特异功能之前，你必须先用 enable 指令来指定你要使用的内功。<br>请参考 help force 可得知一些大部分内功都有的功能，至於你所用的内功到底有没有该功能，试一试或参考其他说明便知。";
        return $ret;
    }
}
