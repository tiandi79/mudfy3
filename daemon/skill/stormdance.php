<?php
/**
*   七宝天岚舞
* 
*/
namespace daemon\skill;

use std\bskill;

class stormdance extends bskill
{
    public $dodge_msg;

    function __construct()
    {
        $this->dodge_msg = array('但是$n身法轻灵，翩翩地飘了开去！');
    }

    public function get_name()
    {
        return '七宝天岚舞';
    }

    public function valid_enable($skill)
    {
        return ($skill == 'dodge') || ($skill == 'move');
    }

    public function query_dodge_msg()
    {
        return $this->dodge_msg[rand(0, count($this->dodge_msg) - 1)];
    }

    public function valid_learn($me = null)
    {
        if ($me->query('gender') != '女性') {
            $me->get_conn()->ssend('七宝天岚舞只有女性才能练。');
            return false;
        }

        if ($me->query('spi') < 20) {
            $me->get_conn()->ssend('你的灵性不够，没有办法练七宝天岚舞。');
            return false;
        }
        return true;
    }

    public function practice_skill($me)
    {
        if ($me->query('sen') < 30) {
            $me->get_conn()->ssend('你的精神太差了，不能练七宝天岚舞。');
            return false;
        }

        $me->receive_damage("sen", 30);
        $me->get_conn()->ssend('你按著所学练了一遍' . $this->get_name() . '。');
        return true;
    }

    public function effective_level()
    {
        return 20;
    }

    public function learn_bonus()
    {
        return 10;
    }

    public function practice_bonus()
    {
        return 20;
    }
    
    public function black_white_ness()
    {
        return 15;
    }
}
