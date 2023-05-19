<?php
/**
*   如意地魔连环八掌
* 
*/
namespace daemon\skill;

class demonstrike
{
    public $actions, $parry_msg, $unarmed_parry_msg;

    function __construct()
    {
        $this->unarmed_parry_msg = array('$n施展出如意地魔连环八掌，轻描淡写的化解了$N的攻势。');
        $this->parry_msg = array('$n使出「粘」字诀，双掌一划，引偏了$N的$w。');
        $this->actions = array(array('action' => '$N双掌一错，一招“魔火天焚”幻出漫天掌影拢向$n的$l', 'dodge' => 30, 'parry' => 10, 'damage' => 50, 'damage_type' => '瘀伤'),
            array('action' => '$N双掌纷飞，一招“魔王食飧”直取$n的$l', 'dodge' => 10, 'parry' => 30, 'damage' => 30, 'damage_type' => '瘀伤'),
            array('action' => '$N暴喝一声，双掌连环推出，一招“魔吼天地”强劲的掌风直扑$n的$l', 'dodge' => 30, 'parry' => 10, 'damage' => 50, 'damage_type' => '瘀伤'),
            array('action' => '$N使出如意地魔连环八掌中的“魔弑森森”，完全将$n的$l笼罩在双掌之下', 'dodge' => 10, 'parry' => 30, 'damage' => 60, 'damage_type' => '瘀伤'),
            array('action' => '$N化掌为刀，一招“乾坤尽魔”，左右掌分砍$n的两处要害', 'dodge' => 20, 'parry' => 30, 'damage' => 40, 'damage_type' => '瘀伤'),
            array('action' => '$N内气上提，全身拔起，一招“魔高和寡”，双掌凌空拍下', 'dodge' => 70, 'parry' => 10, 'damage' => 80, 'damage_type' => '瘀伤'),
            array('action' => '$N提气游走，一招“魔海漭漭”，森森掌风无孔不入般地击向$n的$l', 'parry' => 40, 'force' => 120, 'damage_type' => '瘀伤'),
            array('action' => '$N使出如意地魔连环八掌中的“璞宇浑魔”双掌携天地魔神之威击向$n的$l', 'dodge' => 40, 'force' => 120, 'damage' => 50, 'damage_type' => '瘀伤'));
    }

    public function valid_learn($me = null)
    {
        if ($me->query_temp('weapon') != null || $me->query_temp('second_weapon') != null) {
            $me->get_conn()->ssend('练' . $this->get_name() . '必须空手。');
            return false;
        }

        if ($me->query_skill('demonforce', 1) < 10) {
            $me->get_conn()->ssend('你的天地人魔心法火候不足，无法练如意地魔连环八掌。');
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
        return '如意地魔连环八掌';
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
        return 10;
    }

    public function practice_bonus()
    {
        return 5;
    }
    
    public function black_white_ness()
    {
        return -10;
    }

    public function practice_skill($me)
    {
        if ($me->query('kee') < 30) {
            $me->get_conn()->ssend('你的体力不够了，休息一下再练吧。');
            return false;
        }
        if ($me->query('force') < 5) {
            $me->get_conn()->ssend('你的内力不够了，休息一下再练吧。');
            return false;
        }
        $me->receive_damage("kee", 30);
        $me->add('force', -5);
        $me->get_conn()->ssend('你按著所学练了一遍' . $this->get_name() . '。');
        return true;
    }

    public function effective_level()
    {
        return 10;
    }

    public function perform_action_file($action)
    {
        return CLASS_D . "bandit/demonstrike/" . $action;
    }
}
