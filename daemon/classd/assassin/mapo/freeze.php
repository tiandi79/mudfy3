<?php
/**
*   麻婆寒练术
* 
*/
namespace daemon\classd\assassin\mapo;

use std\msg;

class freeze
{
    function __construct() {

    }

    public function cast($me, $target = null)
    {
        $ob = $me->get_conn();

        if (!$target || !$target->is_character() || !$me->is_fighting($target)) {
            $ob->ssend('麻婆寒练术只能在战斗中使用。');
            return false;
        }
        
        $extra = $me->query_skill('spells');
        if ($extra < 100) {
            $ob->ssend('你的法术不够高。');
            return false;
        }

        if ($target->query("disable_type") == 'HIW<冻僵中>NOR') {
            $ob->ssend('你现在并不需要施展麻婆寒练术。');
            return false;
        }
        
        if ($me->query("mana") < 100) {
            $ob->ssend('你的法力不够。');
            return false;
        }

        if ($me->query('sen') < 50) {
            $ob->ssend('你的精神没有办法有效集中！');
            return false;
        }
        $me->add("mana", -100);
	    $me->receive_damage("sen", 50);

        if (rand(0, $me->query('max_mana')) < 30) {
            $ob->ssend('你失败了！');
            return false;
        }

        $msg = 'HIW$N双手一聚，形成一团奇冷的寒气，向$n射来！NOR<br><br>';        
        $ap = $extra;
        $ap = ($ap * $ap / 100 * $ap / 40) * $me->query("sen") ;
        $dp = $target->query("combat_exp");
        if (rand(0, $ap + $dp) > $dp) {
            $msg .='HIW奇冷的寒气包围了$n的全身，将$n凝聚成冰块！NOR';
            $target->set_temp("disable_inputs", 1);
		    $target->set("disable_type", 'HIW<冻僵中>NOR');
		    $target->set_temp("is_unconcious", 1);
            $target->call_out($extra / 20 + rand(0, $extra / 20), 'remove_eff', array($target, '麻婆寒练术', 0), $this);
        } else {
            $msg .= '但是被$n躲开了。';
        }

        msg::message('vision', $msg, $me, $target);
        $target->kill_ob($me);
        $me->start_busy(2);
        return true;
    }

    public function remove_eff($me, $name, $amount)
    {
        $me->del("disable_type");
        $me->del_temp("disable_inputs");
        $me->del_temp("is_unconcious");
        if (!$me->is_ghost())
	        msg::message('vision', '<br><br>HIR$N发出一声怒吼，双臂一振，将周身凝聚的冰块震得粉碎！！<br><br>NOR', $me);
    }
}
