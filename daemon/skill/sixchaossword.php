<?php
/**
*   六阴追魂剑
* 
*/
namespace daemon\skill;

use std\bskill;

class sixchaossword extends bskill
{
    public $actions, $parry_msg, $unarmed_parry_msg;

    function __construct()
    {
        $this->unarmed_parry_msg = array('$n使出一招「万炼魔障」，在身前布起了一道铜墙铁壁，封住了$N的攻势。',
            '$n一抖手中的$v，使出一招「碧灵魔遁」，手中的$v护住了全身。',
            '$n将$v往地上一刺，$v反弹起来，刚好直刺$N的双臂。',
            '$n举剑静立，一股内力从剑梢透出，逼开了$N。');
        $this->parry_msg = array('$n不退反进，气走周天，一招「鬼魅无边」，手中的$v狠狠磕开了$N的$w。',
            '$n回剑自守，一招「鬼火飘零」，架住了$N的$w。',
            '$n一招「群魔乱舞」，手中的$v化作千百把，护住了全身。',
            '$n手中的$v自上削下，几乎将$N的$w削成两段。');
        $this->actions = array(array('action' => '$N使一招「群魔乱舞」，手中$w狂风骤雨般地向$n的$l连攻数剑', 'dodge' => 50, 'damage' => 170, 'damage_type' => '刺伤'),
            array('action' => '$N身形一转，一招「厉鬼缠身」$w斩向$n的$l', 'dodge' => -50, 'damage' => 20, 'damage_type' => '刺伤'),
            array('action' => '$N舞动$w，一招「百鬼夜行」挟著闪闪剑光刺向$n的$l', 'dodge' => -40, 'damage_type' => '刺伤'),
            array('action' => '$N手中$w一抖，使出「饿鬼拦路」往$n的$l刺出一剑', 'dodge' => -40, 'damage' => 40, 'damage_type' => '刺伤'),
            array('action' => '$N手中$w剑光暴长，一招「鬼影幢幢」往$n$l刺去', 'dodge' => -60, 'damage' => 20, 'damage_type' => '刺伤'),
            array('action' => '$N手中$w直指$n$l，一招「秋坟鬼唱」发出逼人剑气刺去', 'dodge' => -20, 'damage' => 50, 'damage_type' => '刺伤'));
    }

    public function valid_learn($me)
    {
        if ($me->query('max_force') < 100) {
            $me->get_conn()->ssend('你的内力不够，没有办法练六阴追魂剑。');
            return false;
        }

        if (($weapon = $me->query_temp('weapon')) && $weapon->type != 'sword') {
            $me->get_conn()->ssend('你必须先找一把剑才能练剑法。');
            return false;
        }
        return true;
    }

    public function valid_enable($skill)
    {
        return $skill == 'sword' || $skill == 'parry';
    }

    public function get_name()
    {
        return '六阴追魂剑';
    }

    public function query_parry_msg($weapon = null)
    {
        if (isset($weapon))
            return $this->parry_msg[rand(0, count($this->parry_msg) - 1)];
        else
            return $this->unarmed_parry_msg[rand(0, count($this->unarmed_parry_msg) - 1)];
    }

    public function skill_improved($me)
    {
        if ($me->query_skill('sixchaossword', 1) % 10 == 0) {
            $me->get_conn()->ssend('HIR<br>你突然觉得一股恶气冲上心头，只觉得想杀人...NOR');
            $me->add("bellicosity", 1000);
        }
        else
            $me->add("bellicosity", 100);
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

    public function practice_skill($me)
    {
        if (($weapon = $me->query_temp('weapon')) && $weapon->type != 'sword') {
            $me->get_conn()->ssend('你必须先找一把剑才能练剑法。');
            return false;
        }
        if ($me->query('kee') < 30 || $me->query('force') < 3) {
            $me->get_conn()->ssend('你的气或内力不够，不能练六阴追魂剑。');
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
}
