<?php
/**
*   铁布衫
* 
*/
namespace daemon\skill;

class ironcloth
{
    public $absorb_msg = array('$n已有准备，不慌不忙的运起铁布衫。',
        '$n闭目凝神，气走全身，护体硬功达到巅峰状态。',
        '$n「嘿」的一声，不躲不闪，运起铁布衫迎向$N！');
    function __construct()
    {

    }

    public function get_name()
    {
        return '铁布衫';
    }

    public function learn_bonus()
    {
        return 10;
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

    public function skill_improved($me)
    {
        $s = $me->query_skill("ironcloth", 1);
        if ($s % 10 == 9 && $me->fle < $s / 5) {
            $me->get_conn()->ssend('HIW由於你勤练铁布衫，你的韧性提高了。NOR');
            $me->set('fle', 2);
        }
    }

    public function query_absorb_msg()
    {
        return $this->absorb_msg[rand(0, count($this->absorb_msg) - 1)];
    }
}
