<?php
/**
*   短兵技巧
* 
*/
namespace daemon\skill;

class dagger
{
    function __construct()
    {

    }

    public function learn_bonus()
    {
        return 5;
    }

    public function practice_bonus()
    {
        return 0;
    }
    
    public function black_white_ness()
    {
        return 0;
    }

    public function get_name()
    {
        return '短兵刃';
    }

    public function valid_learn($me = null)
    {
        return true;
    }
}
