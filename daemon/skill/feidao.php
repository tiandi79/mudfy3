<?php
/**
*   小李飞刀
* 
*/
namespace daemon\skill;

use std\bskill;

class feidao extends bskill
{
    public $actions, $parry_msg, $unarmed_parry_msg;

    function __construct()
    {
        $this->unarmed_parry_msg = array('$n左拳击下，右拳自保，一招「过桥抽板」，将$N封于尺外。');
        $this->parry_msg = array('$n以守为攻，一招「反客为主」，猛击$N握$w的手腕。');
        $this->actions = array(array('action' => '$N双手一晃，手中的$w如一条银蛇般飞向$n的$l', 'dodge' => -20, 'damage' => 30, 'damage_type' => '刺伤', 'post_action' => 'throw_weapon'),
            array('action' => '$N右手一抖，$w发出刺耳的破空声直射$n的$l', 'dodge' => -40, 'damage' => 30, 'damage_type' => '刺伤', 'post_action' => 'throw_weapon'),
            array('action' => '$N手指微动，$w斜斜的飞向$n的$l', 'dodge' => -40, 'damage_type' => '刺伤', 'post_action' => 'throw_weapon'),
            array('action' => '$N力发肩肘，右手一甩，手中的$w化作一道弧光射向$n的$l', 'dodge' => 20, 'damage' => 40, 'damage_type' => '刺伤', 'post_action' => 'throw_weapon'));
    }

    public function valid_learn($me = null)
    {
        if ($me->query('max_force') < 500) {
            $me->get_conn()->ssend('你的内力不够，没有办法练飞刀绝技。');
            return false;
        }

        if (!$weapon = $me->query_temp('weapon') || $weapon->type != 'throwing') {
            $me->get_conn()->ssend('你必须先找一些暗器才能练飞刀。');
            return false;
        }
        return true;
    }

    public function valid_enable($skill)
    {
        return $skill == 'throwing';
    }

    public function get_name()
    {
        return '小李飞刀';
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
        return -2220;
    }

    public function practice_bonus()
    {
        return -1110;
    }
    
    public function black_white_ness()
    {
        return 15;
    }

    public function practice_skill($me)
    {
        if ($me->query('kee') < 30 || $me->query('force') < 500) {
            $me->get_conn()->ssend('你的内力或气不够，没有办法练习飞刀绝技。');
            return false;
        }
        $me->receive_damage("kee", 30);
        $me->add("force", -30);
        $me->get_conn->ssend('你按著所学练了一遍' . $this->get_name() . '。');
        return true;
    }

    public function effective_level()
    {
        return 15;
    }

    public function perform_action_file($action)
    {
        return CLASS_D . "traveller/feidao/" . $action;
    }
}
