<?php
/**
*   杀人如麻
* 
*/
namespace daemon\classd\assassin\sharensword;

use std\msg;

class sharenruma
{
    function __construct() {

    }

    public function perform($me, $target = null)
    {
        $ob = $me->get_conn();
        if (!$target || !$target->is_character() || !$me->is_fighting($target)) {
            $ob->ssend('杀人如麻只能对战斗中的对手使用。');
            return false;
        }

        $weapon = $me->query_temp("weapon");
        if (!$weapon || $weapon->query('skill_type') != 'sword') {
            $ob->ssend('施展杀人如麻需要一把剑！');
            return false;
        }
        
        $extra = $me->query_skill("sharensword", 1);
        if ($extra < 90) {
            $ob->ssend('你的杀人剑法法还不够纯熟！');
            return false;
        }

        $extra /= 10;

        $msg = 'HIY$N凶性大发，手中的' . $weapon->query('name') . '狂风暴雨般地向$n卷来！NOR';
        msg::message('vision', $msg, $me, $target);

        $extra /= 10;
        $me->add_temp('apply/attack', $extra);
        $me->add_temp('apply/damage', $extra);
        $n = 3 + rand(1, 5);
        global $COMBAT_D, $CHINESE_D;
        for ($i = 1; $i < $n; $i++) {
            $msg = 'HIR第' . $CHINESE_D->chinese_number($i) . '剑！NOR';
            $COMBAT_D->do_attack($me, $target, $weapon, 'TYPE_REGULAR', $msg);
        }

        $me->add_temp('apply/attack', -$extra);
        $me->add_temp('apply/damage', -$extra);
        $me->start_busy(5);
        return true;
    }
}
