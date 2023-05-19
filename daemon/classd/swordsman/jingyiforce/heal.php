<?php
/**
*   heal
* 
*/
namespace daemon\classd\swordsman\jingyiforce;

use std\msg;

class heal
{
    function __construct() {

    }

    public function exert($me, $target = null)
    {
        $ob = $me->get_conn();
        if ($me->is_fighting()) {
            $ob->ssend('战斗中运功疗伤？找死吗？');
            return false;
        }

        if ($me->query("force") < 50) {
            $ob->ssend('你的内力不够。');
            return false;
        }
 
        if ($me->query("eff_kee") < $me->query("max_kee") / 2) {
            $ob->ssend('你已经受伤过重，只怕一运真气便有生命危险！');
            return false;
        }

        msg::message("vision", 'HIW$N坐下来运功疗伤，脸上一阵红一阵白，不久，吐出一口瘀血，脸色看起来好多了。NOR', $me);

        $me->receive_curing("kee", 10 + $me->query_skill("force") / 5 );
        $me->add("force", -50);
        $me->set("force_factor", 0);
        return true;
    }
}
