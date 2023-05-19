<?php
/**
*   读书识字
* 
*/
namespace daemon\skill;

class literate
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
        return '读书识字';
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

    public function skill_improved($me)
    {
        $s = $me->query_skill("literate", 1);
        if ($s % 10 == 9 && $me->int < $s / 5) {
            $me->get_conn()->ssend('HIW由於你的勤学苦读，你的悟性提高了。NOR');
            $me->set('int', 2);
        }
    }
}
