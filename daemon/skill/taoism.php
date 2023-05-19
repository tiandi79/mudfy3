<?php
/**
*   天师正道
* 
*/
namespace daemon\skill;

class taoism
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
        if ($me->query('bellicosity') > 100) {
            $me->get_conn()->ssend('你的杀气太重，无法修炼天师正道。');
            return false;
        }
        return true;
    }

    public function practice_skill($me = null)
    {
        $me->get_conn()->ssend('法术类技能必须用学的或是从实战中获取经验。');
            return false;
    }

    public function get_name()
    {
        return '天师正道';
    }

    public function effective_level()
    {
        return 20;
    }

    public function learn_bonus()
    {
        return -50;
    }

    public function practice_bonus()
    {
        return -25;
    }
    
    public function black_white_ness()
    {
        return 30;
    }
}
