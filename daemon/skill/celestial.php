<?php
/**
*   天邪神功
* 
*/
namespace daemon\skill;

use std\bskill;

class celestial extends bskill
{
    function __construct()
    {
    }

    public function valid_learn($me = null)
    {
        if ($me->query('bellicosity') < $me->query_skill('celestial', 1) * 50) {
            $me->get_conn()->ssend('你的杀气不够，无法领悟更高深的天邪神功。');
            return false;
        }
        return true;
    }

    public function valid_enable($skill)
    {
        return $skill == 'force';
    }

    public function get_name()
    {
        return '天邪神功';
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
        return -50;
    }

    public function practice_skill($me)
    {
        $me->get_conn()->ssend('天邪神功只能用学的，或是从运用(exert)中增加熟练度。');
        return false;
    }

    public function effective_level()
    {
        return 10;
    }

    public function exert_action_file($action)
    {
        return CLASS_D . "fighter/celetial/" . $action;
    }
}
