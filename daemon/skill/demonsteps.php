<?php
/**
*   如意人魔连环八步
* 
*/
namespace daemon\skill;

use std\bskill;

class demonsteps extends bskill
{
    public $dodge_msg;

    function __construct()
    {
        $this->dodge_msg = array('$n一招“魔幻虚影”，全身化出千百个身影躲闪开了$N这一招。',
            '只见$n身影一晃，一式「天璇乱步」早已避在七尺之外。',
            '$n使出「倒转天权」，轻轻松松地闪过。',
            '$n双脚轻踏九曲，一招“魔光旖旎”，身形无比美妙地荡开数尺。',
            '$n使出如意人魔连环八步中的“魔影娉婷”，身形化实为虚地躲开了$N这一招。',
            '$n腾空一跃，双脚凌空虚踏，一招“魔冲霄汉”，躲开数尺。',
            '$n身形晃动，一招“魔心穹隆”，全身化作无数虚影掠出丈外。',
            '$n猛吸一口气，一招“奇魔异形”，身形以一个无比怪异的姿势扭曲着弹开数尺。');
    }

    public function get_name()
    {
        return '如意人魔连环八步';
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
            $me->get_conn()->ssend('你的气或内力不够，不能练' . $this->get_name() . '。');
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
        return 0;
    }

    public function perform_action_file($action)
    {
        return CLASS_D . "bandit/demonsteps/" . $action;
    }
}
