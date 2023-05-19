<?php
/**
*  外功特殊招式
*
*/
namespace cmds\std;

use std\msg;

class perform
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null)
    {
        $me = $ob->body;
        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成，不能施用外功。');
            return false;
        }

        if (!isset($arg)) {
            $ob->ssend('你要用外功做什麽？');
            return false;
        }

        if (!$me->is_fighting()) {
            $ob->ssend('只有在战斗中才能使用此招式。');
            return false;
        }

        $args = explode('.', $arg);
        if (count($args) == 2) {
            $skill_type = $args[0];
            $pfm = $args[1];
        }
        else {
            $weapon = $me->query_temp('weapon');
            if ($weapon == null)
                $skill_type = 'unarmed';
            else {
                $skill_type = $weapon->query('skill_type');   
            }
            $pfm = $args[0];
        }

        $enable_skill = $me->query_skill_mapped($skill_type);
        global $GAMESKILLS;
        if (null == $enable_skill) {
            $ob->ssend('你请先用 enable 指令选择你要使用的外功。');
            return false;
        }
        else {
            $skill = $GAMESKILLS->get($enable_skill);
            if ($skill->perform_action($me, $pfm, $skill_type)) {
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
        $ret = "指令格式：perfrom [<武功种类>.]<招式名称> [<施用对象>]<br>如果你所学的外功(拳脚、剑法、刀法....)有一些特殊的攻击方式或招式，可以用这个指令来使用，你必须先用 enable 指令指定你使用的武功，不指定武功种类时，空手的外功是指你的拳脚功夫，使用武器时则是兵刃的武功。若是你的外功中有种类不同，但是招式名称相同的，或者不属於拳脚跟武器技能的武功(如轻功)，可以用 <武功>.<招式>  的方式指定，如：<br>perform sword.powerfocus <br>perform move.reflexion<br>换句话说，只要是 enable 中的武功有特殊招式的，都可以用这个指令使用。";
        return $ret;
    }
}
