<?php
/**
*  练习
*
*/
namespace cmds\std;

use std\msg;

class practice
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null)
    {
        $me = $ob->body;

        if ($me->is_fighting()) {
            $ob->ssend('你已经在战斗中了，学一点实战经验吧。');
            return false;
        }

        if (!isset($arg)) {
            $ob->ssend('指令格式：practice <基础技能>');
            return false;
        }
        
        $skill = $me->query_skill_mapped($arg);        
        if (!$skill) {
            $ob->ssend('你只能练习用 enable 指定的特殊技能。');
            return false;
        }

        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成！');
            return false;
        }

        $b_skill_lv = $me->query_skill($arg, 1);
        $skill_lv = $me->query_skill($skill, 1);

        if ($b_skill_lv < 1) {
            $ob->ssend('你对这方面的技能还是一窍不通，最好从先从基本学起。');
            return false;
        }

        if ($skill_lv < 1) {
            $ob->ssend('你好像还没「学会」这项技能吧？最好先去请教别人。');
            return false;
        }
        global $GAMESKILLS;
        $p_skill = $GAMESKILLS->get($skill);

        if ($skill_lv > $b_skill_lv) {
            $ob->ssend('你试著练习' . $p_skill->get_name() . '，但是并没有任何进步。');
            return false;
        }

        if (!$p_skill->valid_learn($me)) {
            return false;
        }

	    if ($p_skill->practice_skill($me)) {
		    $amount = ($skill_lv - 75) * $p_skill->black_white_ness() / 100;
		    if (($amount < -25) && ($skill_lv < 75))
                $amount = -25;
		    $amount += $p_skill->practice_bonus() + $b_skill_lv / 5 + 1;
		    if ($amount < 1) 
                $amount = 1;
        	$me->improve_skill($skill, $amount);
		    $ob->ssend('HIY你的' . $p_skill->get_name() . '进步了！NOR');
        }
        return true;
    }

    public function help() 
    {
        $ret = "指令格式：practice <技能种类><br>这个指令让你练习某个种类的技能，这个技能必须是经过 enable 的专业技能。<br>如果你对这方面的基本技能够高，可以经由练习直接升级，而且升级的上限只跟你基本技能的等级有关，换句话说，勤加练习是使你的所学「青出於蓝胜於蓝」的唯一途径，当然，在这之前你必须从实际运用中获得足够的经验以提升你的基本技能。";
        return $ret;
    }
}
