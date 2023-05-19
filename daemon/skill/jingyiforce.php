<?php
/**
*   净衣心法
* 
*/
namespace daemon\skill;

use std\bskill;

class jingyiforce extends bskill
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
        return '净衣心法';
    }

    public function learn_bonus()
    {
        return 10;
    }

    public function practice_bonus()
    {
        return 10;
    }
    
    public function black_white_ness()
    {
        return 20;
    }

    public function practice_skill($me)
    {
        $me->get_conn()->ssend('净衣心法只能用学的，或是从运用(exert)中增加熟练度。');
        return false;
    }

    public function effective_level()
    {
        return 10;
    }

    public function exert_action_file($action)
    {
        return CLASS_D . "swordsman/jingyiforce/" . $action;
    }
}
