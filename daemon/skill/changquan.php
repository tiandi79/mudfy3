<?php
/**
*   少林长拳
* 
*/
namespace daemon\skill;

use std\bskill;

class changquan extends bskill
{
    public $actions, $parry_msg, $unarmed_parry_msg;

    function __construct()
    {
        $this->unarmed_parry_msg = array('$n左拳击下，右拳自保，一招「过桥抽板」，将$N封于尺外。');
        $this->parry_msg = array('$n以守为攻，一招「反客为主」，猛击$N握$w的手腕。');
        $this->actions = array(array('action' => '$N使一招「黑虎掏心」，对准$n的$l「呼」地一拳', 'force' => 40, 'parry' => 20, 'damage_type' => '瘀伤'),
            array('action' => '$N扬起拳头，一招「泰山压顶」便往$n的$l招呼过去', 'force' => 30, 'parry' => 10, 'damage_type' => '瘀伤'),
            array('action' => '$N左手虚晃，右拳「中宫直进」便往$n的$l击出', 'force' => 30, 'parry' => 10, 'damage_type' => '瘀伤'),
            array('action' => '$N步履一沉，左拳拉开，右拳使出「老汉推车」击向$n$l', 'force' => 30, 'parry' => 20, 'damage_type' => '瘀伤'));
    }

    public function valid_learn($me = null)
    {
        if ($me->query_temp('weapon') != null || $me->query_temp('second_weapon') != null) {
            $me->get_conn()->ssend('练少林长拳必须空手。');
            return false;
        }
        return true;
    }

    public function valid_enable($skill)
    {
        return $skill == 'unarmed';
    }

    public function get_name()
    {
        return '少林长拳';
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
        return 0;
    }
    
    public function black_white_ness()
    {
        return 0;
    }

    public function practice_skill($me)
    {
        if ($me->query('kee') < 30) {
            $me->get_conn()->ssend('你的体力不够了，休息一下再练吧。');
            return false;
        }
        $me->receive_damage("kee", 30);
        $me->get_conn()->ssend('你按著所学练了一遍' . $this->get_name() . '。');
        return true;
    }

    public function effective_level()
    {
        return 6;
    }

    public function perform_action_file($action)
    {
        return CLASS_D . "bonze/changquan/" . $action;
    }
}
