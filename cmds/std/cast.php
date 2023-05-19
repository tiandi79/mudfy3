<?php
/**
*  咒术特殊招式
*
*/
namespace cmds\std;

use std\msg;

class cast
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null)
    {
        $me = $ob->body;
        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成，不能念咒文。');
            return false;
        }

        if ($me->get_env()->query('no_magic') != null) {
            $ob->ssend('这里不准念咒文。');
            return false;
        }

        if (!isset($arg)) {
            $ob->ssend('指令格式：cast <法术>');
            return false;
        }

        $enable_skill = $me->query_skill_mapped('spells');
        global $GAMESKILLS;
        if (null == $enable_skill) {
            $ob->ssend('你请先用 enable 指令选择你要使用的咒文。');
            return false;
        }
        else {
            $skill = $GAMESKILLS->get($enable_skill);
            if ($skill->cast_action($me, $arg)) {
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
        $ret = "cast <咒文名称> <br>施法，你必需要指定<咒文名称>，在你使用某一个咒文之前，你必须先用 enable 指令来指定你要使用的咒文系。<br>注：如果你改变自己的咒文系，你原本蓄积的法力并不能直接转换过去，必须从 0 开始。";
        return $ret;
    }
}
