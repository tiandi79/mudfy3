<?php
/**
*   闪躲
* 
*/
namespace daemon\skill;

class dodge
{
    public $dodge_msg;

    function __construct()
    {
        $this->dodge_msg = array('但是和$l偏了几寸。',
            '但是被$n机灵地躲开了。',
            '但是$n身子一侧，闪了开去。',
            '但是被$n及时避开。',
            '但是$n已有准备，不慌不忙的躲开。');
    }

    public function get_name()
    {
        return '纵跃闪躲之术';
    }

    public function query_dodge_msg()
    {
        return $this->dodge_msg[rand(0, count($this->dodge_msg) - 1)];
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
