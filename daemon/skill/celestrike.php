<?php
/**
*   天邪神掌
* 
*/
namespace daemon\skill;

class celestrike
{
    public $actions, $parry_msg, $unarmed_parry_msg;

    function __construct()
    {
        $this->unarmed_parry_msg = array('$n步走七星，一招「反客为主」虚空拍出十三掌，逼得$N撤招自保。',
            '$n化掌为指，一招「掌指双飞」反点$N的周身要穴。',
            '$n施展出「掌指双飞」，轻描淡写的化解了$N的攻势。');
        $this->parry_msg = array('$n化掌为刀，一招「碧血五指挑」急切$N拿着$w的手。',
            '$n双掌交错，使出一招「童子拜寿」，「啪」的一声将$N的$w夹在双掌之间。',
            '$n略一转身，一招「兵出无名」拍向$N拿着$w的手。');
        $this->actions = array(array('action' => '$N使出一招「大天罗式」，右掌穿出击向$n的$l', 'dodge' => -30, 'force' => 200, 'parry' => 10, 'damage_type' => '瘀伤'),
            array('action' => '$N使出一招「大天罗式」，左掌化虚为实击向$n的$l', 'dodge' => -10, 'force' => 70, 'parry' => -30, 'force' => 100, 'damage_type' => '瘀伤'),
            array('action' => '$N使出天邪掌法「小天罗式」，如鬼魅般欺至$n身前，一掌拍向$n的$l', 'dodge' => -30, 'force' => 150, 'parry' => 10, 'damage_type' => '瘀伤'),
            array('action' => '$N双掌一错，使出「雪阳三连月」，对准$n的$l连续拍出三掌', 'dodge' => 10, 'force' => 160, 'parry' => -30, 'damage_type' => '瘀伤'),
            array('action' => '$N左掌画了个圈圈，右掌推出，一招「灵动五方鼓」击向$n$l', 'dodge' => -20, 'force' => 240, 'parry' => -30, 'damage_type' => '瘀伤'),
            array('action' => '$N吐气扬声，一招「气撼九重天」双掌并力推出', 'force' => 320, 'parry' => -40, 'damage_type' => '瘀伤'),
            array('action' => '$N使出「风雷七星断」，身形散作七处同时向$n的$l出掌攻击', 'dodge' => -70, 'force' => 280, 'parry' => 10, 'damage_type' => '瘀伤'));
    }

    public function valid_learn($me = null)
    {
        if ($me->query_temp('weapon') != null || $me->query_temp('second_weapon') != null) {
            $me->get_conn()->ssend('练' . $this->get_name() . '必须空手。');
            return false;
        }

        if ($me->query_skill('celestial', 1) < 20) {
            $me->get_conn()->ssend('你的天邪神功火候不足，无法练天邪掌法。');
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
        return '天邪神掌';
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
        return 10;
    }

    public function practice_bonus()
    {
        return 5;
    }
    
    public function black_white_ness()
    {
        return -10;
    }

    public function practice_skill($me)
    {
        if ($me->query('kee') < 30) {
            $me->get_conn()->ssend('你的体力不够了，休息一下再练吧。');
            return false;
        }
        if ($me->query('force') < 5) {
            $me->get_conn()->ssend('你的内力不够了，休息一下再练吧。');
            return false;
        }
        $me->receive_damage("kee", 30);
        $me->add('force', -5);
        $me->get_conn()->ssend('你按著所学练了一遍' . $this->get_name() . '。');
        return true;
    }

    public function effective_level()
    {
        return 10;
    }
}
