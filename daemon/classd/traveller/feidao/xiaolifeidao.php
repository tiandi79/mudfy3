<?php
/**
*   小李飞刀
* 
*/
namespace daemon\classd\traveller\feidao;

use std\msg;

class xiaolifeidao
{
    function __construct() {

    }

    public function perform($me, $target = null)
    {
        $ob = $me->get_conn();
        if (!$target || !$target->is_character() || !$me->is_fighting($target)) {
            $ob->ssend('小李飞刀只能对战斗中的对手使用。');
            return false;
        }

        $weapon = $me->query_temp("weapon");
        if (!$weapon || $weapon->query('skill_type') != 'throwing') {
            $ob->ssend('施展小李飞刀需要一把飞刀！');
            return false;
        }
        if ($me->query_skill('feidao', 1) <= 200) {
            $ob->ssend('你的飞刀绝技还不够精纯，不能发出小李飞刀。');
            return false;
        }

        msg::message('vision', 'HIR$N目不转睛地盯着$n，准备发出致命一击。NOR', $me, $target);
        $me->start_busy(5);
        $me->call_out(5, 'kill_him', array($me, $target), $this);
        return true;
    }

    public function kill_him($me, $target)
    {
        if ($me->is_fighting($target) && ($me->get_env() == $target->get_env())) {
            msg::message('vision', '<br>HIY$N使出飞刀绝技中例无虚发的HIR小李飞刀NORHIY，$n只觉得眼前一花，咽喉已被对穿而过！！！<br>一股血箭喷涌而出．．$n的眼睛死鱼般的突了出来．．', $me, $target);
            $target->die();
        }
    }
}
