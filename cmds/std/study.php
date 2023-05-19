<?php
/**
*  读
*
*/
namespace cmds\std;

use std\msg;

class study
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null, $sena = null)
    {
        $me = $ob->body;

        if ($me->is_fighting()) {
            $ob->ssend('你无法在战斗中专心下来研读新知！');
            return false;
        }

        if (!isset($arg) || !isset($sena)) {
            $ob->ssend('指令格式：study <物品> <神数量>');
            return false;
        }

        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成！');
            return false;
        }

        if (!$book = $me->is_environment($arg)) {
            if (!$book = $me->is_carry($arg)) {
                $ob->ssend('你要读什么？');
                return false;
            }
        }

        if (!$skill = $book->query('skill')) {
            $ob->ssend('你无法从这样东西学到任何东西。');
            return false;
        }

        if (isset($skill['literate']))
            $liter = $skill['literate'];
        else
            $liter = 'literate';

        global $GAMESKILLS;
        $liter_skill = $GAMESKILLS->get($liter);
        if ($me->query_skill($liter, 1) < 1) {
            $ob->ssend('你看不懂耶．．，先学学' . $liter_skill->get_name() . '吧。');
            return false;
        }

        msg::message('vision', '$N正专心地研读$n。', $me, $book);
        if ($me->query('combat_exp') < $skill['exp_required']) {
            $ob->ssend('你的实战经验不足，再怎麽读也没用。');
            return false;
        }

        $study_skill = $GAMESKILLS->get($skill['name']);
        if (!$study_skill->valid_learn($me)) {
            $ob->ssend($study_skill->get_name() . '只能用学的。');
            return false;
        }

        $cost = $skill["sen_cost"] + $skill["sen_cost"] * ($skill["difficulty"] - intval($me->query_attr('int'))) / 20;
	    $cost = intval($cost / 2);
        if ($cost < 1) 
            $cost = 1;
        global $CHINESE_D;
	    if ($cost > $sena) {
	        $ob->ssend('以你目前的能力，你至少要花' . $CHINESE_D->chinese_number($cost) . '点神');
            return false;
        }

        if ($me->query('sen') <= $sena) {
            $ob->ssend('你现在过於疲倦，无法专心下来研读新知。');
            return false;
        }

        if ($me->query_skill($skill['name'], 1) > $skill['max_skill']) {
            $ob->ssend('你研读了一会儿，但是发现上面所说的对你而言都太浅了，没有学到任何东西。');
            return false;
        }

        $my_skill = $me->query_skill_eff_lvl($skill['name']);
        if ($my_skill * $my_skill * $my_skill > $me->query("combat_exp")) {
            $ob->ssend('以你现在的实战经验，再怎麽读也无法领会。');
            return false;
        }

        $me->receive_damage("sen", $sena);

	    if (!$me->query_skill($skill['name'], 1))
		    $me->set_skill($skill['name'], 0);
	    $amount = ($me->query_skill($skill['name']) - 75) * $study_skill->black_white_ness() / 100;
        if ($amount < -25 && $me->query_skill($skill['name']) < 75) 
            $amount = -25;
	    $amount += $me->query_skill($liter, 1) / 5 + 1;
	    if ($amount < 1) 
            $amount = 1;
	    $amount = intval($amount * $sena / $cost);
	    $me->improve_skill($skill['name'], $amount);
        $ob->ssend('你研读有关' . $study_skill->get_name() . '的技巧，似乎有点心得。');
        return true;
    }

    public function help() 
    {
        $ret = "指令格式: study <物品名称><br>这个指令使你可以从秘笈或其他物品自学某些技巧,但前提是: 你一定要懂秘笈上的文字。";
        return $ret;
    }
}
