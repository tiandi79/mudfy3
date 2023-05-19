<?php
/**
*   玉环鸳鸯拳
* 
*/
namespace daemon\classd\bonze\changquan;

use std\msg;

class yuhuan
{
    function __construct() {

    }

    public function perform($me, $target = null)
    {
        $ob = $me->get_conn();
        if (!$target || !$target->is_character() || !$me->is_fighting($target)) {
            $ob->ssend('玉环鸳鸯拳只能对战斗中的对手使用。');
            return false;
        }

        $extra = $me->query_skill('unarmed');
        if ($extra < 200) {
            $ob->ssend('你的少林长拳还不够纯熟！');
            return false;
        }

        $me->add("force_factor", $extra / 5);
	    $orforce = $me->query("force");
	    $me->add("force", $extra / 5 * 100);
	    $me->add_temp("apply/attack", $extra / 10);
	    $weapon = $me->query_temp("weapon");
        $msg = 'HIY$N使出少林长拳中的［玉环鸳鸯拳］，一招连环七式向$n攻出！NOR';
        msg::message('vision', $msg, $me, $target);

        global $COMBAT_D;
        $msg = 'HIY上一拳！NOR';
        $COMBAT_D->do_attack($me, $target, $weapon, 'TYPE_REGULAR', $msg);
        $msg = 'HIY下一拳！NOR';
        $COMBAT_D->do_attack($me, $target, $weapon, 'TYPE_REGULAR', $msg);
        $msg = 'HIY左一拳！NOR';
        $COMBAT_D->do_attack($me, $target, $weapon, 'TYPE_REGULAR', $msg);
        $msg = 'HIY右一拳！NOR';
        $COMBAT_D->do_attack($me, $target, $weapon, 'TYPE_REGULAR', $msg);
        $msg = 'HIY前一拳！NOR';
        $COMBAT_D->do_attack($me, $target, $weapon, 'TYPE_REGULAR', $msg);
        $msg = 'HIY后一拳！NOR';
        $COMBAT_D->do_attack($me, $target, $weapon, 'TYPE_REGULAR', $msg);
        $msg = 'HIY最后再一拳！NOR';
        $COMBAT_D->do_attack($me, $target, $weapon, 'TYPE_REGULAR', $msg);
        $me->start_busy(5);
	    $me->set("force_factor", 0);
	    $me->set("force", $orforce);
        $me->add_temp("apply/attack", -$extra / 10);
        return true;
    }
}
