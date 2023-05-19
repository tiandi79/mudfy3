<?php
/**
*   空手搏斗
* 
*/
namespace daemon\skill;

class unarmed
{
    public $unarmed_parry_msg, $parry_msg;

    function __construct()
    {
        $this->unarmed_parry_msg = array('但是被$n格开了。',
            '结果被$n挡开了。');
        $this->parry_msg = array('只听见「锵」一声，被$n格开了。',
            '结果「当」地一声被$n挡开了。',
            '但是被$n用手中兵刃架开。',
            '但是$n身子一侧，用手中兵刃格开。');
    }

    public function valid_learn($me = null)
    {
        return true;
    }

    public function get_name()
    {
        return '扑击格斗之技';
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
        return 5;
    }

    public function practice_bonus()
    {
        return 0;
    }
    
    public function black_white_ness()
    {
        return 0;
    }

    public function skill_improved($me)
    {
        $s = $me->query_skill("unarmed", 1);
        if ($s % 10 == 9 && $me->str < $s / 5) {
            $me->get_conn()->ssend('HIW由於你勤练武艺，你的力量提高了。NOR');
            $me->set('str', 2);
        }
    }
}
