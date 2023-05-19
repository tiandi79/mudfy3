<?php
/**
*   用人之技
* 
*/
namespace daemon\skill;

class leadership
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
        return '用人之技';
    }

    public function effective_level()
    {
        return 10;
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

    public function skill_improve($me)
    {
        $s = $me->query_skill("leadership", 1);
        if ($s % 10 == 9 && $me->per < $s / 5) {
            $me->get_conn()->ssend('HIW由於你的勤学用人之技，你的魅力提高了。NOR');
            $me->add('per', 2);
        }
    }
}
