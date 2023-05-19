<?php
/**
*   满江红心法
* 
*/
namespace daemon\skill;

class manjianghong
{
    function __construct()
    {
    }

    public function valid_learn($me = null)
    {
        return true;
    }

    public function valid_enable($skill)
    {
        return $skill == 'force';
    }

    public function get_name()
    {
        return '满江红心法';
    }

    public function learn_bonus()
    {
        return 3;
    }

    public function practice_bonus()
    {
        return -10;
    }
    
    public function black_white_ness()
    {
        return 15;
    }

    public function practice_skill($me)
    {
        $me->get_conn()->ssend('满江红心法只能用学的，或是从运用(exert)中增加熟练度。');
        return false;
    }

    public function effective_level()
    {
        return 15;
    }
}
