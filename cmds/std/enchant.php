<?php
/**
*  enchant
*
*/
namespace cmds\std;

class enchant
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null)
    {
        $me = $ob->body;
        
        if ($arg == null || (!is_numeric($arg) && $arg != 'none')) {
            $ob->ssend('指令格式：enchant <灵力点数>|none');
            return false;
        }

        if (null == $me->query_skill_mapped("spells")) {
            $ob->ssend('你必须先用 enable 选择你要用的咒术。');
            return false;
        }

        if ($arg == 'none')
            $me->del('mana_factor');
        else {
            if ($arg < 0 || $arg > $me->query_skill('spells') / 3) {
                $ob->ssend('你的灵力不足，发不出那麽强的威力。');
                return false;
            }
            $me->set('mana_factor', intval($arg));
        }
        $ob->ssend('OK。');
        return true;
    }

    public function help() 
    {
        $ret = "指令格式: enchant <灵力点数><br>这个指令让你设定使用魔法武器时要用来导引武器魔力所用的灵力强度。<br>不同的武器所需的灵力不同，威力也不一样，有些魔力强大的武器如果使用者<br>无法发出足以驾驭它的灵力，就有可能产生可怕的後果。";
        return $ret;
    }
}
