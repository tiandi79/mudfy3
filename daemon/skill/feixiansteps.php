<?php
/**
*   飞仙步法
* 
*/
namespace daemon\skill;

use std\bskill;

class feixiansteps extends bskill
{
    public $dodge_msg;

    function __construct()
    {
        $this->dodge_msg = array('$n一招「天玑离枢」轻轻巧巧地避了开去。',
            '只见$n身影一晃，一式「天璇乱步」早已避在七尺之外。',
            '$n使出「倒转天权」，轻轻松松地闪过。',
            '$n左足一点，一招「逐影天枢」腾空而起，避了开去。',
            '可是$n使一招「风动玉衡」，身子轻轻飘了开去。',
            '$n身影微动，已经藉一招「开阳薄雾」轻轻闪过。',
            '但是$n一招「瑶光音迟」使出，早已绕到$N身後！');
    }

    public function get_name()
    {
        return '飞仙步法';
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
        if ($me->query('max_force') < 50) {
            $me->get_conn()->ssend('你的内力不够，没有办法练飞仙步法。');
            return false;
        }
        return true;
    }

    public function practice_skill($me)
    {
        if ($me->query('kee') < 30 || $me->query('force') < 3) {
            $me->get_conn()->ssend('你的气或内力不够，不能练飞仙步法。');
            return false;
        }
        $me->receive_damage("kee", 30);
        $me->add('force', -3);
        $me->get_conn()->ssend('你按著所学练了一遍' . $this->get_name() . '。');
        return true;
    }

    public function effective_level()
    {
        return 20;
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

    public function perform_action_file($action)
    {
        return CLASS_D . "swordsman/feixiansteps/" . $action;
    }
}
