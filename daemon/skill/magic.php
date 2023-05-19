<?php
/**
*   法术
* 
*/
namespace daemon\skill;

class magic
{
    function __construct()
    {

    }

    public function get_name()
    {
        return '法术';
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
