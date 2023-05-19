<?php
/**
*   妙手空空
* 
*/
namespace daemon\skill;

use std\bskill;

class stealing extends bskill
{
    function __construct()
    {
    }

    public function valid_enable($skill)
    {
        return false;
    }   

    public function valid_learn($me = null)
    {
        return true;
    }

    public function get_name()
    {
        return '妙手空空';
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
}
