<?php
/**
*   右手诀
* 
*/
namespace daemon\classd\assassin\lefthandsword;

class duxin
{
    function __construct() {

    }

    public function perform($me, $target = null)
    {
        $ob = $me->get_conn();
        if (!$target || !$target->is_character() || !$me->is_fighting($target)) {
            $ob->ssend('右手诀只能对战斗中的对手使用。');
            return false;
        }

        $weapon = $me->query_temp("weapon");
        if (!$weapon || $weapon->query('skill_type') != 'sword') {
            $ob->ssend('施展右手诀需要一把剑！');
            return false;
        }

        $extra = intval($me->query_skill("lefthandsword", 1) / 10);
        $me->add_temp('apply/attack', $extra);
        $me->add_temp('apply/damage', $extra);

        global $COMBAT_D;

        $msg = 'HIR$N将' . $weapon->query('name') . '换到右手，更快，更毒，更准地向$n刺出！NOR';
        $COMBAT_D->do_attack($me, $target, $weapon, 'TYPE_REGULAR', $msg);

        $me->add_temp('apply/attack', -$extra);
        $me->add_temp('apply/damage', -$extra);
        $me->start_busy(2);
        return true;
    }
}
