<?php
/**
*   人类构造器
*
*/
namespace adm\daemons\race;

class human
{
    function __construct()
    {

    }

    public function setup_human($me)
    {
        $me->can_speak = true;
        $me->attitude = 'peaceful';
        if (!isset($me->national))
            $me->national = "汉族";

        if (!isset($me->age))
            $me->age = rand(0, 30) + 15;
        if (!isset($me->str))
            $me->str = rand(0, 25) + 5;
        if (!isset($me->cor))
            $me->cor = rand(0, 20) + 5;
        if (!isset($me->int))
            $me->int = rand(0, 5) + 20;
        if (!isset($me->spi))
            $me->spi = rand(0, 20) + 5;
        if (!isset($me->cps))
            $me->cps = rand(0, 20) + 5;
        if (!isset($me->per))
            $me->per = rand(0, 20) + 5;
        if (!isset($me->con))
            $me->con = rand(0, 20) + 5;
        if (!isset($me->kar))
            $me->kar = rand(0, 20) + 5;
        if (!isset($me->agi))
            $me->agi = rand(0, 20) + 5;
        if (!isset($me->dur))
            $me->dur = rand(0, 2) + 1;
        if (!isset($me->fle))
            $me->fle = rand(0, 20) + 5;
        if (!isset($me->tol))
            $me->tol = rand(0, 20) + 5;
        
        if (!isset($me->max_gin)) {
            if ($me->age <= 14)
                $me->max_gin = 100 + $me->spi * 10;
            elseif ($me->age <= 20)
                $me->max_gin = 100 + $me->spi * 10 + ($me->age - 14) * 20;
            elseif ($me->age <= 30)
                $me->max_gin = 220 + $me->spi * 10;
            elseif ($me->age <= 60)
                $me->max_gin = 220 - ($me->age - 30) * 5 + $me->spi * 10;
            else
                $me->max_gin = 70 + $me->spi * 10;

            if (isset($me->max_atman) && $me->max_atman > 0)
                $me->max_gin += $me->max_atman;

            $me->max_gin += $me->dur * $me->dur;
        }

        if (!isset($me->max_kee)) {
            if ($me->age <= 14)
                $me->max_kee = 100 + $me->con * 10;
            elseif ($me->age <= 20)
                $me->max_kee = 100 + $me->con * 10 + ($me->age - 14) * 20;
            else
                $me->max_kee = 220 + $me->con * 10;

            if (isset($me->max_force) && $me->max_force > 0)
                $me->max_kee += $me->max_force;

            $me->max_kee += $me->dur * $me->dur;
        }

        if (!isset($me->max_sen)) {
            if ($me->age <= 30)
                $me->max_sen = 100 + $me->int * 10;
            else
                $me->max_sen = 100 + ($me->age - 30) * 5 + $me->int * 10;

            if (isset($me->max_mana) && $me->max_mana > 0)
                $me->max_sen += $me->max_mana;

            $me->max_sen += $me->dur * $me->dur;
        }

        $default_actions = array(array('action' => '$N挥拳攻击$n的$l', 'damage_type' => '瘀伤'),
            array('action' => '$N往$n的$l一抓', 'damage_type' => '抓伤'),
            array('action' => '$N往$n的$l狠狠地踢了一脚', 'damage_type' => '瘀伤'),
            array('action' => '$N提起拳头往$n的$l捶去', 'damage_type' => '瘀伤'),
            array('action' => '$N对准$n的$l用力挥出一拳', 'damage_type' => '瘀伤'));

        $me->set('default_actions', $default_actions);

        $limbs = array("头部",	"颈部",	"胸口",	"後心",	"左肩",	"右肩",	"左臂", "右臂",	"左手",	"右手",	"腰间",	"小腹",	"左腿",	"右腿",	"左脚",	"右脚", "左肋", "右肋", "前胸", "后背", "眉心", "后腰", "后颈", "左胯", "右胯", "后脑", "左眼", "右眼", "左颊", "右颊");
        $me->set('limbs', $limbs);
    }
}
