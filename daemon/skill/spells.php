<?php
/**
*   咒术
* 
*/
namespace daemon\skill;

class spells
{
    function __construct()
    {

    }

    public function get_name()
    {
        return '咒术';
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
}
