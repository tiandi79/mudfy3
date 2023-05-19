<?php
/**
*   苍龙乍现
* 
*/
namespace daemon\classd\assassin\jinhongsteps;

use std\msg;

class canglongyixian
{
    function __construct() {

    }

    public function perform($me, $target = null)
    {
        $ob = $me->get_conn();
        if (!$target || !$target->is_character() || !$me->is_fighting($target)) {
            $ob->ssend('苍龙乍现只能对战斗中的对手使用。');
            return false;
        }

        $extra = intval($me->query_skill("jinhongsteps", 1) / 5);
        $me->add_temp('apply/attack', $extra);

        global $COMBAT_D;

        $msg = 'HIR$N脚下一转，突然身形飞起，双脚如矫龙般腾空一卷，猛地向$n踢出！NOR';
        $COMBAT_D->do_attack($me, $target, null, 'TYPE_REGULAR', $msg, '瘀伤');

        $me->add_temp('apply/attack', -$extra);
        $me->start_busy(2);
        return true;
    }
}
