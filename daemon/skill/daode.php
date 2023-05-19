<?php
/**
*   道德经
* 
*/
namespace daemon\skill;

class daode
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
            $me->get_conn()->ssend('你的杀气太重，无法修炼道德经。');
            return false;
        }
        return true;
    }

    public function get_name()
    {
        return '道德经';
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
