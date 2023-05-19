<?php
/**
*   孝道
* 
*/
namespace daemon\skill;

class xiaodao
{
    public $type;

    function __construct()
    {
        $type = 'knowledge';
    }

    public function valid_enable($skill)
    {
        return $skill == 'literate';
    }   

    public function valid_learn($me = null)
    {
        return true;
    }

    public function get_name()
    {
        return '孝道';
    }

    public function effective_level()
    {
        return 20;
    }

    public function learn_bonus()
    {
        return -30;
    }

    public function practice_bonus()
    {
        return -10;
    }
    
    public function black_white_ness()
    {
        return 40;
    }
}
