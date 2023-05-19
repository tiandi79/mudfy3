<?php
/**
*   龙凤双环
* 
*/
namespace daemon\skill;

use std\bskill;

class longfenghuan extends bskill
{
    public $actions, $parry_msg;

    function __construct()
    {
        $this->unarmed_parry_msg = array('$n将手中的$v舞得密不透风，封住了$N的攻势。');
        $this->parry_msg = array('结果$n用手中的$v格开了$N的$w。');
        $this->actions = array(array('action' => '$N单脚金鸡独立，缓缓展出龙凤双环的起手式「八面威风」，手中$w挥向$n的丹田！', 'dodge' => 500, 'force' => 500, 'parry' => 400, 'damage_type' => '挫伤', 'post_action' => 'bash_weapon'),
            array('action' => '$N手中$w相碰，发出＂隆隆＂声，一招「先声夺人」攻向$n$l！', 'dodge' => 600, 'force' => 600, 'parry' => 200, 'damage_type' => '挫伤', 'post_action' => 'bash_weapon'),
            array('action' => '$N手中$w凌空一挥，使出龙凤双环中的「龙飞凤舞」击向$n$l！', 'dodge' => 100, 'force' => 500, 'parry' => 400, 'damage_type' => '挫伤', 'post_action' => 'bash_weapon'),
            array('action' => '$N使出一招「游龙在天」，$w夹杂着风声撞向$n$l！', 'dodge' => 100, 'force' => 800, 'parry' => 400, 'damage_type' => '挫伤', 'post_action' => 'bash_weapon'));
    }

    public function valid_learn($me)
    {
        if ($me->query('str') + $me->query('max_force') / 10  < 50) {
            $me->get_conn()->ssend('你的膂力还不够，也许该练一练内力来增强力量。');
            return false;
        }

        if (($weapon = $me->query_temp('weapon')) && $weapon->type != 'hammer') {
            $me->get_conn()->ssend('你必须先找一双环或者是类似的武器，才能练龙凤双环。');
            return false;
        }
        return true;
    }

    public function valid_enable($skill)
    {
        return $skill == 'hammer' || $skill == 'parry';
    }

    public function get_name()
    {
        return '龙凤双环';
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
        return -100;
    }
    
    public function black_white_ness()
    {
        return 10;
    }

    public function practice_skill($me)
    {
        if (($weapon = $me->query_temp('weapon')) && $weapon->type != 'hammer') {
            $me->get_conn()->ssend('你必须先找一双环或者是类似的武器，才能练龙凤双环。');
            return false;
        }
        if ($me->query('kee') < 60 || $me->query('force') < 3) {
            $me->get_conn()->ssend('你的气或内力不够，不能练龙凤双环。');
            return false;
        }
        $me->receive_damage("kee", 60);
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
        return CLASS_D . "assassin/longfenghuan/" . $action;
    }
}
