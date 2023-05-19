<?php
/**
*  enforce
*
*/
namespace cmds\std;

class enforce
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null)
    {
        $me = $ob->body;
        
        if ($arg == null || (!is_numeric($arg) && $arg != 'none')) {
            $ob->ssend('指令格式：enforce <使出几成内力伤敌>|none');
            return false;
        }

        if (null == $me->query_skill_mapped("force")) {
            $ob->ssend('你必须先用 enable 选择你要用的内功心法。');
            return false;
        }

        if ($arg == 'none')
            $me->del('force_factor');
        else {
            if ($arg < 0 || $arg > $me->query_skill('force') / 3) {
                $ob->ssend('你的内功无法发挥这么大的威力。');
                return false;
            }
            $me->set('force_factor', intval($arg));
        }
        $ob->ssend('OK。');
        return true;
    }

    public function help() 
    {
        $ret = "指令格式: enforce <使出几点内力伤敌>|none<br>这个指令让你指定每次击中敌人时，要发出几点内力伤敌。<br>enforce none 则表示你不使用内力。 ";
        return $ret;
    }
}
