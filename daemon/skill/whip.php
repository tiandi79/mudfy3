<?php
/**
*   鞭法
* 
*/
namespace daemon\skill;

class whip
{
    function __construct()
    {
    }

    public function learn_bonus()
    {
        return -5;
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
        return '基础鞭法';
    }

    public function valid_learn($me = null)
    {
        return true;
    }
}
