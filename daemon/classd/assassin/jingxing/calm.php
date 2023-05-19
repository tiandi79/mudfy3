<?php
/**
*   calm
* 
*/
namespace daemon\classd\assassin\jingxing;

use std\msg;

class calm
{
    function __construct() {

    }

    public function exert($me, $target = null)
    {
        $ob = $me->get_conn();

        if ($target && $target != $me->query('id')) {
            $ob->ssend('你只能提升自己的定力。');
            return false;
        }

        if ($me->query("force") < 100) {
            $ob->ssend('你的内力不够。');
            return false;
        }

        if ($me->query_temp('calm') != null) {
            $ob->ssend('你已经在运行中了。');
            return false;
        }
        $skill = $me->query_skill("jingxing", 1);
        if ($skill < 10) {
            $ob->ssend('你的静行心法太差了！');
            return false;
        }

        $me->add('force', -100);
        
        msg::message("vision", 'HIR$N深深地呼出一口气，整个人处于心神和一的境界．．．NOR', $me);
        $me->set_temp('calm', 1);
        $me->add_temp("apply/cps", intval($skill / 10));
        $me->call_out($skill, 'remove_eff', array($me, '静行心法', intval($skill / 10)), $this);
        if ($me->is_fighting())
            $me->start_busy(3);
        else
            $me->start_busy(1);
        return true;
    }

    public function remove_eff($me, $name, $amount)
    {
        $me->add_temp("apply/cps", -$amount);
        $me->del_temp("calm");
        $me->get_conn()->ssend("你的" . $name . "运行完毕，将内力收回丹田。");
    }
}
