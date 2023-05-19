<?php
/**
*   飞仙剑法
* 
*/
namespace daemon\skill;

use std\bskill;

class lefthandsword extends bskill
{
    public $actions, $parry_msg;

    function __construct()
    {
        $this->actions = array(array('action' => '$N上前一步，手中$w毒蛇般刺向$n的$l', 'dodge' => 50, 'damage' => 70, 'damage_type' => '刺伤'),
            array('action' => '$N身形一转，反手一挥，手中$w刺向$n的$l', 'dodge' => 50, 'damage' => 20, 'damage_type' => '刺伤'),
            array('action' => '$n眼前一花，$N手中的$w已经迅捷无比的刺向$n的$l', 'dodge' => 40, 'force' => 100, 'damage_type' => '刺伤'),
            array('action' => '$N只攻不守，手中$w一抖，往$n的$l刺出一剑', 'dodge' => 40, 'damage' => 40, 'damage_type' => '刺伤'),
            array('action' => '$N的「左手剑法」只有[31m刺[37m，简单而有效地往$n的$l刺去', 'dodge' => 60, 'force' => 100, 'damage' => 80, 'damage_type' => '刺伤'),
            array('action' => '$N手中$w直指$n$l，发出逼人剑气闪电般刺去', 'dodge' => 20, 'damage' => 20, 'damage_type' => '刺伤'));
    }

    public function valid_learn($me)
    {
        if (($weapon = $me->query_temp('weapon')) && $weapon->type != 'sword') {
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
        return '左手剑';
    }

    public function learn_bonus()
    {
        return 20;
    }

    public function practice_bonus()
    {
        return 10;
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
            $me->get_conn()->ssend('你的气或内力不够，不能练左手剑。');
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

    public function perform_action_file($action)
    {
        return CLASS_D . "assassin/lefthandsword/" . $action;
    }
}
