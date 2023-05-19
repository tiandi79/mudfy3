<?php
/**
*   麻婆寒练术
* 
*/
namespace daemon\skill;

use std\bskill;

class mapo extends bskill
{
    function __construct()
    {
    }

    public function valid_enable($skill)
    {
        return $skill == 'spells';
    }   

    public function valid_learn($me = null)
    {
        return true;
    }

    public function get_name()
    {
        return '麻婆寒练术';
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

    public function cast_action_file($action)
    {
        return CLASS_D . "assassin/mapo/" . $action;
    }
}
