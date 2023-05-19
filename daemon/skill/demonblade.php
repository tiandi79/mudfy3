<?php
/**
*   如意天魔连环八式
* 
*/
namespace daemon\skill;

use std\bskill;

class demonblade extends bskill
{
    public $actions, $parry_msg, $unarmed_parry_msg;

    function __construct()
    {
        $this->unarmed_parry_msg = array('$n使出天魔连环八式中的“魔障无边”，手中的$v化成九重刀幕护住全身。');
        $this->parry_msg = array('$n使出天魔连环八式中的“魔障无边”，手中的$v化成九重刀幕护住全身。');
        $this->actions = array(array('action' => '$N使出天魔八式中的起手式“万魔初醒”，手中的$w划出一溜光芒斩向$n的$l', 'force' => 500, 'damage_type' => '割伤'),
            array('action' => '$N手一抖，一招“魔焰万丈”手中的$w幻成一片刀花，散向$n的$l', 'force' => 300, 'damage_type' => '割伤'),
            array('action' => '$N刀锋忽转，手中的$w一招“魔光乍现”，闪电般劈向$n的$l', 'force' => 200, 'damage_type' => '割伤'),
            array('action' => '$N身影晃动，刀锋忽左忽右，一招“天魔独尊”，手中的$w，从中路突然砍至$n的$l', 'force' => 300, 'damage_type' => '割伤'),
            array('action' => '$N的双脚点地，刀背贴身，一招“万刃天魔”全身转出一团刀光滚向$n', 'force' => 200, 'damage_type' => '割伤'),
            array('action' => '$N刀刃向上，一招“天魔回天”，从一个$n意想不到的角度撩向$n的$l', 'force' => 200, 'damage_type' => '割伤'),
            array('action' => '$N你手中的$w左右横划，一招“天魔七现”，来来回回地狂扫向$n的$l', 'force' => 100, 'damage_type' => '割伤'),
            array('action' => '$N使出如意天魔连环八式中的收手式“万魔归宗”，手中的$w迅捷无比地砍向$n的$l', 'force' => 500, 'damage_type' => '割伤'));
    }

    public function valid_learn($me)
    {
        if ($me->query_skill('demonforce') < 60) {
            $me->get_conn()->ssend('你的天地人魔心法火候不足，无法练如意天魔连环八式。');
            return false;
        }
        if ($me->query_temp('weapon') == null) {
            $me->get_conn()->ssend('你必须先找一把刀才能练剑法。');
            return false;
        }
        if (($weapon = $me->query_temp('weapon')) && $weapon->type != 'balde') {
            $me->get_conn()->ssend('你必须先找一把刀才能练刀法。');
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
        return '如意天魔连环八式';
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
        return 0;
    }

    public function practice_bonus()
    {
        return -5;
    }
    
    public function black_white_ness()
    {
        return 20;
    }

    public function practice_skill($me)
    {
        if ($me->query_temp('weapon') == null) {
            $me->get_conn()->ssend('你必须先找一把刀才能练剑法。');
            return false;
        }
        if (($weapon = $me->query_temp('weapon')) && $weapon->type != 'blade') {
            $me->get_conn()->ssend('你必须先找一把刀才能练剑法。');
            return false;
        }
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

    public function perform_action_file($action)
    {
        return CLASS_D . "bandit/demonblade/" . $action;
    }
}
