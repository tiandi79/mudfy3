<?php
/**
*   基本轻功
* 
*/
namespace daemon\skill;

class move
{
    function __construct()
    {
    }

    public function get_name()
    {
        return '基本轻功';
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

    public function valid_learn($me = null)
    {
        return true;
    }

    public function skill_improved($me)
    {
        $s = $me->query_skill("move", 1);
        if ($s % 10 == 9 && $me->agi < $s / 5) {
            $me->get_conn()->ssend('HIW由於你勤练轻功，你的速度提高了。NOR');
            $me->set('agi', 2);
        }
    }
}
