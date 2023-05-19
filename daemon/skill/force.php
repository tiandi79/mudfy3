<?php
/**
*   内功
* 
*/
namespace daemon\skill;

class force
{
    function __construct()
    {

    }

    public function get_name()
    {
        return '内功心法';
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
        $s = $me->query_skill("force", 1);
        if ($s % 10 == 9 && $me->con < $s / 5) {
            $me->get_conn()->ssend('HIW由於你的内功修炼有成，你的体质改善了。NOR');
            $me->add('con', 2);
        }
    }
}
