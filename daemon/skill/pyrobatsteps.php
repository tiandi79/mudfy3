<?php
/**
*   火蝠身法
* 
*/
namespace daemon\skill;

use std\bskill;

class pyrobatsteps extends bskill
{
    public $dodge_msg;

    function __construct()
    {
        $this->dodge_msg = array('但是$n身形飘忽，轻轻一纵，一招「幻蝠隐踪」，举重若轻的避开这一击。',
            '$n身随意转，一式「轻蝠点梢」，倏地往一旁挪开了三尺，避过了这一招。',
            '可是$n侧身一让，使出「寒蝠掠江」，$N这一招扑了个空。',
            '却见$n足不点地，一招「夜蝠旋身」，往旁窜开数尺，躲了开去。',
            '$n身形微晃，使出「灵蝠轻逝」，有惊无险地避开了$N这一招。',
            '$n身形往上一拔，一招「火蝠曳空」，一个转折落在数尺之外。');
    }

    public function get_name()
    {
        return '火蝠身法';
    }

    public function valid_enable($skill)
    {
        return ($skill == 'dodge') || ($skill == 'move');
    }

    public function query_dodge_msg()
    {
        return $this->dodge_msg[rand(0, count($this->dodge_msg) - 1)];
    }

    public function valid_learn($me = null)
    {
        return true;
    }

    public function practice_skill($me)
    {
        if ($me->query('kee') < 30 || $me->query('force') < 3) {
            $me->get_conn()->ssend('你的气或内力不够，不能练火蝠身法。');
            return false;
        }
        $me->receive_damage("kee", 30);
        $me->add('force', -3);
        $me->get_conn()->ssend('你按著所学练了一遍' . $this->get_name() . '。');
        return true;
    }

    public function effective_level()
    {
        return 10;
    }

    public function learn_bonus()
    {
        return 0;
    }

    public function practice_bonus()
    {
        return 0;
    }
    
    public function black_white_ness()
    {
        return 10;
    }
}
