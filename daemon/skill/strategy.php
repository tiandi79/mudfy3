<?php
/**
*   兵法
* 
*/
namespace daemon\skill;

class strategy
{
    public $type;

    function __construct()
    {
        $type = 'knowledge';
    }

    public function valid_learn($me = null)
    {
        return true;
    }

    public function get_name()
    {
        return '兵法';
    }

    public function effective_level()
    {
        return 10;
    }

    public function learn_bonus()
    {
        return 20;
    }

    public function practice_bonus()
    {
        return 0;
    }
    
    public function black_white_ness()
    {
        return 0;
    }

    public function skill_improve($me)
    {
        $s = $me->query_skill("leadership", 1);
        if ($s % 10 == 9 && $me->cor < $s / 5) {
            $me->get_conn()->ssend('HIW由於你的勤学兵法，你的勇气提高了。NOR');
            $me->add('cor', 2);
        }
    }
}
