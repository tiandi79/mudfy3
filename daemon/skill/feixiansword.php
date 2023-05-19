<?php
/**
*   飞仙剑法
* 
*/
namespace daemon\skill;

use std\bskill;

class feixiansword extends bskill
{
    public $actions, $parry_msg, $unarmed_parry_msg;

    function __construct()
    {
        $this->unarmed_parry_msg = array('$n将手中的$v舞得密不透风，封住了$N的攻势。',
            '$n反手一招「阳光普照」，整个人消失在一团剑光之中。',
            '$n使出一招「龙舞九天」，$v直刺$N的双手。',
            '$n将手中的$v化做七条剑气，迫得$N连连后退。');
        $this->parry_msg = array('$n使出一招「凤舞九天」，手中的$v化作一条长虹，磕开了$N的$w。',
            '$n使出「封」字诀，将$N的$w封于丈外。',
            '$n使出一招「朝朝瑞雪」，手中的$v化做漫天雪影，荡开了$N的$w。',
            '$n手中的$v一抖，一招「旱地春雷」，向$N拿$w的手腕削去。');
        $this->actions = array(array('action' => '$N使一招「峰回路转」，手中$w如一条银蛇般刺向$n的$l', 'dodge' => -20, 'damage' => 30, 'damage_type' => '刺伤'),
            array('action' => '$N使出飞仙剑法中的「空山鸟语」，剑光霍霍斩向$n的$l', 'dodge' => -20, 'damage' => 30, 'damage_type' => '割伤'),
            array('action' => '$N一招「御风而行」，身形陡然滑出数尺，手中$w斩向$n的$l', 'dodge' => -30, 'damage' => 20, 'damage_type' => '割伤'),
            array('action' => '$N手中$w中宫直进，一式「旭日东升」对准$n的$l刺出一剑', 'dodge' => -40, 'damage_type' => '割伤'),
            array('action' => '$N纵身一跃，手中$w一招「金光泻地」对准$n的$l斜斜刺出一剑', 'dodge' => -40, 'damage_type' => '刺伤'),
            array('action' => '$N的$w凭空一指，一招「一剑西来」刺向$n的$l', 'dodge' => 20, 'damage' => 40, 'damage_type' => '刺伤'),
            array('action' => '$N手中$w向外一分，使一招「柳暗花明」反手对准$n$l一剑刺去', 'dodge' => -20, 'damage' => 20, 'damage_type' => '刺伤'),
            array('action' => '$N横剑上前，身形一转手中$w使一招「仙云密布」画出一道光弧刺向$n的$l', 'dodge' => -30, 'damage' => 50, 'damage_type' => '刺伤'));
    }

    public function valid_learn($me)
    {
        if ($me->query('max_force') < 50) {
            $me->get_conn()->ssend('你的内力不够，没有办法练飞仙剑法。');
            return false;
        }
        if ($me->query_skill_mapped('force') != 'jingyiforce') {
            $me->get_conn()->ssend('飞仙剑法必须配合净衣心法才能练。');
            return false;
        }
        if ($me->query_temp('weapon') == null) {
            $me->get_conn()->ssend('你必须先找一把剑才能练剑法。');
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
        return '飞仙剑法';
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
        return 20;
    }

    public function practice_bonus()
    {
        return 10;
    }
    
    public function black_white_ness()
    {
        return 15;
    }

    public function practice_skill($me)
    {
        if ($me->query_temp('weapon') == null) {
            $me->get_conn()->ssend('你必须先找一把剑才能练剑法。');
            return false;
        }
        if (($weapon = $me->query_temp('weapon')) && $weapon->type != 'sword') {
            $me->get_conn()->ssend('你必须先找一把剑才能练剑法1。');
            return false;
        }
        if ($me->query('kee') < 30 || $me->query('force') < 3) {
            $me->get_conn()->ssend('你的气或内力不够，不能练飞仙剑法。');
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

    public function perform_action_file($action)
    {
        return CLASS_D . "swordsman/feixiansword/" . $action;
    }
}
