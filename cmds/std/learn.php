<?php
/**
*  学习
*
*/
namespace cmds\std;

use std\msg;

class learn
{
    public $reject_msg = array("说道：您太客气了，这怎麽敢当？", "像是受宠若惊一样，说道：请教？这怎麽敢当？", "笑著说道：您见笑了，我这点雕虫小技怎够资格「指点」您什麽？");
    function __construct()
    {
    }

    public function do_cmd($ob, $skillname = null, $from = 'from', $name = null, $pot = 1)
    {
        $me = $ob->body;
        
        if ($me->is_fighting()) {
            $ob->ssend('临阵磨枪？来不及啦。');
            return false;
        }

        if (!isset($skillname) || !isset($from) || !isset($name) || !isset($pot) || $from != 'from') {
            $ob->ssend('指令格式：learn <技能> from <默认> <潜能点>');
            return false;
        }

        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成！');
            return false;
        }

        if (!$master = $me->is_environment($name)) {
            $ob->ssend('你要向谁求教？');
            return false;
        }

        if (!$master->living()) {
            $ob->ssend('嗯....你得先把' . $master->query('name') . '弄醒再说。');
            return false;
        }

        if (!is_numeric($pot)) {
            $ob->ssend('潜能点只能是正整数！');
            return false;
        }

        if ($pot < 0) {
            $ob->ssend('潜能点最少是一！');
            return false;
        }

        if (!$me->is_apprentice_of($master) && !$me->is_couple($master)) {
            if (!method_exists($master, 'recognize_apprentice')) {
                msg::message_text('vision', $master->query('name') . $this->reject_msg[rand(0, count($this->reject_msg) - 1)], $me);
                return false;
            }
            elseif (!$master->recognize_apprentice($me))
                return false;
        }

        if (0 == $master->query_skill($skillname)) {
            $ob->ssend('这项技能你恐怕必须找别人学了。');
            return false;
        }

        if ($this->prevent_learn($me, $master, $skillname)) {
            $ob->ssend($master->query('name') . '不愿意教你这项技能。');
            return false;
        }

        if ($master->is_couple($me)) {
            if ($this->couple_learn($me, $master, $skillname)) {
                $ob->ssend($master->query('name') . '不愿意教你这项技能。');
                return false;
            }
        }

        $my_skill = $me->query_skill_eff_lvl($skillname);
        $master_skill = $master->query_skill_eff_lvl($skillname);
        if ($my_skill >= $master_skill) {
            $ob->ssend('这项技能你的程度已经不输你师父了。');
            return false;
        }

        global $GAMESKILLS;
        $skill = $GAMESKILLS->get($skillname);
        if (!$skill->valid_learn($me)) {
            $ob->ssend('这项技能不能学。');
            return false;
        }

        $gin_cost = 100 / $me->query_attr('int');

        if ($me->query_skill($skillname) == 0) {
            $gin_cost *= 2;
        }
	    $gin_cost *= $pot;

        if ($me->query('potential') < $pot) {
            $ob->ssend('你的潜能已经发挥到极限了，没有办法再成长了。');
            return false;
        }

        $ob->ssend('你向' . $master->query('name') . "请教有关「". $skill->get_name() .'」的疑问。');
        if ($master->query('env/no_teach') != null) {
            $ob->ssend('但是' . $master->query('name') . '现在并不准备回答你的问题。');
            return false;
        }

        if ($master->is_player()) {
            $maseter->get_conn->ssend($me->query('name') . '你请教有关「' . $skill->get_name() . '」的问题。');
        }

        if ($me->query("gin") > $gin_cost) {
            if(($my_skill * $my_skill * $my_skill) / 10 > $me->query("combat_exp")) {
                $ob->ssend('也许是因为缺乏经验，你对' . $master->query('name') . '的回答总是无法领会。');
            } else {
                $ob->ssend('你听了' . $master->query('name') . '的指导，似乎有些心得。');
                $me->add("learned_points", $pot);
                $me->add('potential', -$pot);
	            $amount = ($my_skill - 75) * $skill->black_white_ness() / 100;
	            if (($amount < -50) && ($my_skill < 75))
                    $amount = -50;
                $amount += $skill->learn_bonus() + $me->query_attr('int') * $me->query_attr('int') + intval(pow($me->query("combat_exp"), 0.3));
	            $amount = $amount / 50 + rand(0, $amount / 50);
	            if ($amount < 2) 
                    $amount = 2;	
	            $amount *= $pot;
                $me->improve_skill($skillname, intval($amount));
            }
        } else {
            $gin_cost = $me->query("gin");
            $ob->ssend('你今天太累了，结果什麽也没有学到。');
        }
        $me->receive_damage("gin", $gin_cost);
    }

    public function couple_learn($me, $couple, $skill)
    {
        if (!$me->is_couple($couple))
            return true;
        $myskill = $me->query_skill($skill);
        $coupleskill = $couple->query_skill($skill);
        $div = $me->query('divorced');
        $ratio = 1;
        for ($i = 1;$i <= $div;$i++)
            $ratio *= 2;
        if (($myskill >= $coupleskill / $ratio) && ($ratio != 1)) {
            msg::message('$N神色间似乎对$n不是十分信任，也许是想起$p从前离婚的事情...。', $couple, $me);
            return true;
        }
        return false;
    }

    public function prevent_learn($me, $master, $skill)
    {
        $myskill = $me->query_skill($skill);
        $masterskill = $master->query_skill($skill);
        $betrayer = $me->query('betrayer');

        if ($myskill >= ($masterskill - 20 * $betrayer)) {
            msg::message('vision', '$N神色间似乎对$n不是十分信任，也许是想起$p从前背叛师门的事情...。', $master, $me);
            return true;
        }
        return false;
    }

    public function help() 
    {
        $ret = "指令格式 : learn <技能> from <某人> <潜能点><br>这个指令可以让你向别人请教有关某一种技能的疑难问题，当然，你请教的对象在这项技能上的造诣必须比你高，而你经由这种方式学习得来的技能也不可能高於你所请教的人，然而因为这种学习方式相当於一种「经验的传承」，因此学习可以说是熟悉一种新技能最快的方法。<br>通常，一个人刚学到一种新技能是不会有什麽疑难问题的，而是经由实际上的应用中遭遇问题，这些问题对於学习一种新技能的过程是很重要的，尤其是各种作为其他技能基础的基本技能，更需要经由「发现问题—解决问题」的过程才能得到较好的效果因此我们将这种发现问题的过程用「潜能」的观念表示，一个人能够自己发现某些问题，表示他(她)有解决这项问题的潜能，当你具有这样的潜能时就可以利用这个指令来向其他人请教，而获得进步。(PS. 潜能还有其他更广义的定义，这里只是其中之一 )<br>此外学习也需要消耗一些精力，而消耗的精力跟你自己、与你学习对象的悟性有关。<br>至於如何知道你能从对方学到什麽技能，如果对方是你的师父，可以用 skills 指令直接查看，如果不是你的师父，那麽通常会有其他的提示，你只好自己想办法。<br>其他相关指令 : practice、study";
        return $ret;
    }
}
