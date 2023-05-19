<?php
/**
*   秋风步法
* 
*/
namespace daemon\skill;

use std\bskill;

class fallsteps extends bskill
{
    public $dodge_msg;

    function __construct()
    {
        $this->dodge_msg = array('$n一招「秋风起兮白云飞」轻轻巧巧地避了开去。',
            '只见$n身影一晃，一式「草木黄落兮雁南归」早已避在七尺之外。',
            '$n使出「兰有秀兮菊有芳」，轻轻松松地闪过。',
            '$n左足一点，一招「怀佳人兮不能忘」腾空而起，避了开去。',
            '可是$n使一招「泛楼船兮济汾河」，身子轻轻飘了开去。',
            '$n身影微动，已经藉一招「横中流兮扬素波」轻轻闪过。',
            '但是$n一招「箫鼓鸣兮发棹歌」使出，早已绕到$N身後！',
            '但是$n身形飘忽，轻轻一纵，一招「欢乐极兮哀情多」，避开这一击。',
            '$n身形往上一拔，一招「少壮几时兮奈老何」，一个转折落在数尺之外。');
    }

    public function get_name()
    {
        return '秋风步法';
    }

    public function valid_enable($skill)
    {
        return ($skill == 'dodge');
    }

    public function query_dodge_msg()
    {
        return $this->dodge_msg[rand(0, count($this->dodge_msg) - 1)];
    }

    public function valid_learn($me = null)
    {
        if ($me->query('max_force') < 50) {
            $me->get_conn()->ssend('你的内力不够，没有办法练秋风步法。');
            return false;
        }
        return true;
    }

    public function practice_skill($me)
    {
        if ($me->query('kee') < 30 || $me->query('force') < 3) {
            $me->get_conn()->ssend('你的气或内力不够，不能练秋风步法。');
            return false;
        }
        $me->receive_damage("kee", 30);
        $me->add('force', -3);
        $me->get_conn()->ssend('你按著所学练了一遍' . $this->get_name() . '。');
        return true;
    }

    public function effective_level()
    {
        return 15;
    }

    public function learn_bonus()
    {
        return -20;
    }

    public function practice_bonus()
    {
        return -10;
    }
    
    public function black_white_ness()
    {
        return 40;
    }

    public function perform_action_file($action)
    {
        return CLASS_D . "legend/fallsteps/" . $action;
    }
}
