<?php
/**
*   speedup
* 
*/
namespace daemon\classd\swordsman\jingyiforce;

use std\msg;

class speedup
{
    function __construct() {

    }

    public function exert($me, $target = null)
    {
        $ob = $me->get_conn();

        if ($me->query("force") < 100) {
            $ob->ssend('你的内力不够。');
            return false;
        }

        if ($me->query_temp('speedup') != null) {
            $ob->ssend('你已经在运行中了。');
            return false;
        }
        $skill = $me->query_skill("jingyiforce", 1);
        if ($skill < 20) {
            $ob->ssend('你的净衣心法太差了！');
            return false;
        }

        $me->add('force', -100);
        
        msg::message("vision", 'HIR$N暗暗地聚气凝神，整个人处于一触即发的状态！NOR', $me);
        $me->set_temp('speedup', 1);
        $me->add_temp("apply/agi", intval($skill / 20));
        $me->call_out(intval($skill / 2), 'remove_eff', array($me, '净衣心法', intval($skill / 20)), $this);
        if ($me->is_fighting())
            $me->start_busy(3);
        else
            $me->start_busy(1);
        return true;
    }

    public function remove_eff($me, $name, $amount)
    {
        $me->add_temp("apply/agi", -$amount);
        $me->del_temp("speedup");
        $me->get_conn()->ssend("你的" . $name . "运行完毕，整个人又松懈了下来。");
    }
}
