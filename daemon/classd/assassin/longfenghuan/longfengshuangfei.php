<?php
/**
*   龙凤双飞
* 
*/
namespace daemon\classd\assassin\longfenghuan;

class longfengshuangfei
{
    function __construct() {

    }

    public function perform($me, $target = null)
    {
        $ob = $me->get_conn();
        if (!$target || !$target->is_character() || !$me->is_fighting($target)) {
            $ob->ssend('龙凤双飞只能对战斗中的对手使用。');
            return false;
        }

        $weapon = $me->query_temp("weapon");
        if (!$weapon || $weapon->query('skill_type') != 'hammer') {
            $ob->ssend('施展龙凤双飞需要双环或者类似武器！');
            return false;
        }

        $extra = $me->query_skill("longfenghuan", 1);
        if ($extra < 80) {
            $ob->ssend('你的龙凤双环还不够纯熟！');
            return false;
        }
        $extra /= 10;
        $me->add_temp('apply/attack', $extra);
        $me->add_temp('apply/damage', $extra);

        global $COMBAT_D;

        $msg = 'HIR$N双臂一震，一招［龙凤双飞］，手中的' . $weapon->query('name') . '飞出击向$n！NOR';
        $COMBAT_D->do_attack($me, $target, $weapon, 'TYPE_REGULAR', $msg);

        if ($me->unequip($weapon))
            $weapon->move($me->get_env());
        $me->add_temp('apply/attack', -$extra);
        $me->add_temp('apply/damage', -$extra);
        $me->start_busy(2);
        return true;
    }
}
