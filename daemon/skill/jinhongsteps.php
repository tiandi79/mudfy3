<?php
/**
*   秋风步法
* 
*/
namespace daemon\skill;

use std\bskill;

class jinhongsteps extends bskill
{
    public $dodge_msg;

    function __construct()
    {
        $this->dodge_msg = array('$n一招「金钱撒地」轻轻巧巧地避了开去。',
            '只见$n身影一晃，一式「万象争辉」早已避在七尺之外。',
            '$n使出「黄花满地」，轻轻松松地闪过。',
            '$n左足一点，一招「白柳横坡」腾空而起，避了开去。',
            '可是$n使一招「玉树临风」，身子轻轻飘了开去。');
    }

    public function get_name()
    {
        return '金虹步法';
    }

    public function valid_enable($skill)
    {
        return $skill == 'dodge' || $skill == 'move';
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
            $me->get_conn()->ssend('你的气或内力不够，不能练金虹步法。');
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

    public function perform_action_file($action)
    {
        return CLASS_D . "assassin/jinhongsteps/" . $action;
    }
}
