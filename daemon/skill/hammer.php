<?php
/**
*   锤法
* 
*/
namespace daemon\skill;

class hammer
{
    function __construct()
    {
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

    public function get_name()
    {
        return '基础锤法';
    }

    public function valid_learn($me = null)
    {
        return true;
    }
}
