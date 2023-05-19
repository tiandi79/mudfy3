<?php
/**
*   天外飞仙
* 
*/
namespace daemon\classd\swordsman\feixiansword;

use std\msg;

class tianwaifeixian
{
    function __construct() {

    }

    public function perform($me, $target = null)
    {
        $ob = $me->get_conn();
        if (!$target || !$target->is_character() || !$me->is_fighting($target)) {
            $ob->ssend('天外飞仙只能对战斗中的对手使用。');
            return false;
        }

        $weapon = $me->query_temp("weapon");
        if (!$weapon || $weapon->query('skill_type') != 'sword') {
            $ob->ssend('施展天外飞仙需要一把剑！');
            return false;
        }
        $sword_skill = $me->query_skill_mapped('sword');
        if (!$sword_skill || $sword_skill != 'feixiansword') {
            $ob->ssend('天外飞仙只能和飞仙剑法配和！');
            return false;
        }

        $extra = intval($me->query_skill("feixiansword", 1) / 10);
        $me->add_temp('apply/attack', $extra);
        $me->add_temp('apply/damage', $extra);

        global $COMBAT_D;

        $msg = 'HIR$N使出［飞仙剑法中］的精髓－－天外飞仙，手中的' . $weapon->query('name') . '划出一道长虹，闪电般的击向$n！NOR';
        $COMBAT_D->do_attack($me, $target, $weapon, 'TYPE_REGULAR', $msg);
        $msg = 'HIW剑光一闪，消失．．．．NOR';
        msg::message('vision', $msg, $me, $target);

        $me->add_temp('apply/attack', -$extra);
        $me->add_temp('apply/damage', -$extra);
        $me->start_busy(2);
        return true;
    }
}
