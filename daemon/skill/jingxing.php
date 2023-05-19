<?php
/**
*   静行心法
* 
*/
namespace daemon\skill;

use std\bskill;

class jingxing extends bskill
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
        return '静行心法';
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
        return 10;
    }

    public function practice_skill($me)
    {
        $me->get_conn()->ssend('静行心法只能用学的，或是从运用(exert)中增加熟练度。');
        return false;
    }

    public function effective_level()
    {
        return 12;
    }

    public function exert_action_file($action)
    {
        return CLASS_D . "assassin/jingxing/" . $action;
    }
}
