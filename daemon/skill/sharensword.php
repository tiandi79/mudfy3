<?php
/**
*   杀人剑法
* 
*/
namespace daemon\skill;

use std\bskill;

class sharensword extends bskill
{
    public $actions, $parry_msg;

    function __construct()
    {
        $this->actions = array(array('action' => '$N手中的$w在一弹指间已向$n的$l连刺数剑', 'dodge' => 50, 'parry' => 100, 'force' => 170, 'damage' => 50, 'damage_type' => '刺伤'),
            array('action' => '$N身形一转，手中的$w从左肋下向$n的$l戳了过去', 'dodge' => 50, 'damage' => 70, 'damage_type' => '刺伤'),
            array('action' => '$N手腕一抖，$w挟著闪闪剑光逼向$n的$l', 'dodge' => 40, 'force' => 120, 'damage' => 50, 'damage_type' => '刺伤'),
            array('action' => '$N身形一矮，手中的$w由下往上刺向$n的$l', 'dodge' => 40, 'damage' => 80, 'damage_type' => '刺伤'),
            array('action' => '$N手中$w剑光暴长，如千年蛇蝎往$n$l咬去', 'dodge' => 60, 'damage' => 120, 'damage_type' => '刺伤'),
            array('action' => '$N手中的$w以无法形容的速度直射$n的$l', 'dodge' => 20, 'damage' => 50, 'force' => 100, 'damage_type' => '刺伤'));
    }

    public function valid_learn($me)
    {
        if ($me->query('max_force') < 200) {
            $me->get_conn()->ssend('你的内力不够，没有办法练杀人剑法。');
            return false;
        }
        $weapon = $me->query_temp('weapon');
        if (!isset($weapon) || $weapon->type != 'sword') {
            $me->get_conn()->ssend('你必须先找一把剑才能练剑法。');
            return false;
        }
        return true;
    }

    public function valid_enable($skill)
    {
        return $skill == 'sword';
    }

    public function get_name()
    {
        return '杀人剑法';
    }

    public function learn_bonus()
    {
        return -20;
    }

    public function practice_bonus()
    {
        return -30;
    }
    
    public function black_white_ness()
    {
        return -20;
    }

    public function practice_skill($me)
    {
        if (($weapon = $me->query_temp('weapon')) && $weapon->type != 'sword') {
            $me->get_conn()->ssend('你必须先找一把剑才能练剑法。');
            return false;
        }
        if ($me->query('kee') < 30 || $me->query('force') < 3) {
            $me->get_conn()->ssend('你的气或内力不够，不能练杀人剑法。');
            return false;
        }
        $me->receive_damage("kee", 30);
        $me->add('force', -3);
        $me->get_conn()->ssend('你按著所学练了一遍' . $this->get_name() . '。');
        return true;
    }

    public function skill_improved($me)
    {
        $s = $me->query_skill("sharensword", 1);
        if ($s % 10 == 0) {
            $me->get_conn()->ssend('HIR你突然觉得一股恶气冲上心头，只觉得想杀人....NOR');
            $me->add('bellicosity', 1000);
        }
        else
            $me->add('bellicosity', 100);
    }

    public function effective_level()
    {
        return 15;
    }

    public function perform_action_file($action)
    {
        return CLASS_D . "assassin/sharensword/" . $action;
    }
}
