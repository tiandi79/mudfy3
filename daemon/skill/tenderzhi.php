<?php
/**
*   柔虹指
* 
*/
namespace daemon\skill;

class tenderzhi
{
    public $actions, $parry_msg, $unarmed_parry_msg;

    function __construct()
    {
        $this->unarmed_parry_msg = array('$n并起二指，凌空虚点，指风直奔$N的周身大穴。');
        $this->parry_msg = array('$n中指微弹$N$w的尖端，$N手中的$w几乎脱手而出。');
        $this->actions = array(array('action' => '$N左手一挥，一招「菊楼采月」右手点向$n$l', 'dodge' => -30, 'force' => 80, 'parry' => 30, 'damage_type' => '瘀伤' , 'weapon' => '右手食指',),
            array('action' => '$N使一招「雪桥翦梅」，身影忽前忽後，突然一转身左手往$n的$l点去', 'dodge' => -30, 'force' => 90, 'parry' => 30, 'damage_type' => '刺伤', 'weapon' => '左手食指'),
            array('action' => '$N身法稍顿，左手一扬使出「柳亭簪花」往$n的$l点去', 'dodge' => -30, 'force' => 140, 'parry' => 30, 'damage_type' => '刺伤', 'weapon' => '左手食指'),
            array('action' => '只见$N纤腰一摆，陡然滑出数尺，右手顺著来势一招「桃坟扑蝶」往$n的$l点去', 'dodge' => -30, 'force' => 90, 'parry' => 30, 'damage_type' => '刺伤', 'weapon' => '右手食指'));
    }

    public function valid_learn($me = null)
    {
        if ($me->query('gender') != '女性') {
            $me->get_conn()->ssend('柔虹指是只有女子才能练的武功。');
            return false;
        }

        if ($me->query('max_force') < 250) {
            $me->get_conn()->ssend('你的内力不够！');
            return false;
        }

        if ($me->query_temp('weapon') != null || $me->query_temp('second_weapon') != null) {
            $me->get_conn()->ssend('练柔虹指必须空手。');
            return false;
        }
        return true;
    }

    public function valid_enable($skill)
    {
        return $skill == 'unarmed';
    }

    public function get_name()
    {
        return '柔虹指';
    }

    public function query_parry_msg($weapon = null)
    {
        if (isset($weapon))
            return $this->parry_msg[rand(0, count($this->parry_msg) - 1)];
        else
            return $this->unarmed_parry_msg[rand(0, count($this->unarmed_parry_msg) - 1)];
    }

    public function learn_bonus()
    {
        return -100;
    }

    public function practice_bonus()
    {
        return -100;
    }
    
    public function black_white_ness()
    {
        return 50;
    }

    public function practice_skill($me)
    {
        if ($me->query('sen') < 30) {
            $me->get_conn()->ssend('你的精神无法集中了，休息一下再练吧。');
            return false;
        }

        if ($me->query('force') < 10) {
            $me->get_conn()->ssend('你的内力不够了。');
            return false;
        }

        $me->receive_damage("sen", 30);
        $me->add('force', -10);
        $me->get_conn()->ssend('你按著所学练了一遍' . $this->get_name() . '。');
        return true;
    }

    public function effective_level()
    {
        return 20;
    }
}
