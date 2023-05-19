<?php
/**
*   一剪梅花手
* 
*/
namespace daemon\skill;

class meihuashou
{
    public $actions, $parry_msg, $unarmed_parry_msg;

    function __construct()
    {
        $this->unarmed_parry_msg = array('$n一招「薄雾浓云愁永昼」，逼得$N中途撤招。',
            '$n脚走阴阳，一招「东篱把酒黄昏后」，攻$N之必救。',
            '$n左手拂下，右手一招「花自飘零水自流」，将$N封于尺外。',
            '$n双手齐出，使出一招「此情无计可消除」，$N的功势入泥牛入海，消失得无影无踪。');
        $this->parry_msg = array('$n一招「红藕香残玉簟秋」，右手轻拂$N的面门，逼得$N中途撤回手中的$w。',
            '$n右手虚幌，左手一招「云中谁寄锦书来」，逼得$N后退三步。',
            '$n以守为攻，一招「花自飘零水自流」，轻拂$N握$w的手腕。',
            '$n一招「此情无计可消除」，轻轻一托$N握$w的手，引偏了$N的$w。');
        $this->actions = array(array('action' => '$N使一招「轻解罗裳」，对准$n的$l轻飘飘的扫去', 'dodge' => -20, 'parry' => 20, 'damage_type' => '瘀伤'),
            array('action' => '$N扬起右手，一招「独上兰舟」便往$n的$l拍去', 'dodge' => -10, 'parry' => 10, 'damage_type' => '瘀伤'),
            array('action' => '$N左手虚晃，右手「月满西楼」往$n的$l击出', 'dodge' => -20, 'parry' => 20, 'damage_type' => '瘀伤'),
            array('action' => '$N左手微分，右手一长使出一招「雁字回时」，抓向$n的$l', 'dodge' => -50, 'force' => 100, 'parry' => -30, 'damage_type' => '抓伤'),
            array('action' => '$N倏地一个转身，双手一挑「一种相思」直掼$n$l', 'dodge' => -10, 'force' => 110, 'parry' => -60, 'damage_type' => '抓伤'),
            array('action' => '$N左手虚晃，右掌飘飘，一招「两处闲愁」击向$n$l', 'dodge' => -20, 'force' => 150, 'parry' => -50, 'damage_type' => '挫伤'),
            array('action' => '$N右手在$n$l划过，随後一招「才下眉头」左爪又向同一方位抓到', 'force' => 60, 'parry' => -50, 'damage_type' => '抓伤'),
            array('action' => '$N左手虚晃，右手握成拳，一招「却上心头」击向$n$l', 'dodge' => -20, 'force' => 150, 'parry' => -50, 'damage_type' => '挫伤'));
    }

    public function valid_learn($me = null)
    {
        if ($me->query_temp('weapon') != null || $me->query_temp('second_weapon') != null) {
            $me->get_conn()->ssend('练一剪梅花手必须空手。');
            return false;
        }
        return true;
    }

    public function valid_enable($skill)
    {
        return $skill == 'unarmed';
    }

    public function get_name()
    {
        return '一剪梅花手';
    }

    public function query_parry_msg($weapon = null)
    {
        if (isset($weapon))
            return $this->parry_msg[rand(0, count($this->parry_msg) - 1)];
        else
            return $this->unarmed_parry_msg[rand(0, count($this->unarmed_parry_msg) - 1)];
    }

    public function learn_bonus()
    {
        return 0;
    }

    public function practice_bonus()
    {
        return -20;
    }
    
    public function black_white_ness()
    {
        return 30;
    }

    public function practice_skill($me)
    {
        if ($me->query('kee') < 30) {
            $me->get_conn()->ssend('你的体力不够了，休息一下再练吧。');
            return false;
        }
        if ($me->query('force') < 5) {
            $me->get_conn()->ssend('你的内力不够了，休息一下再练吧。');
            return false;
        }
        $me->receive_damage("kee", 30);
        $me->add('force', -5);
        $me->get_conn()->ssend('你按著所学练了一遍' . $this->get_name() . '。');
        return true;
    }

    public function effective_level()
    {
        return 15;
    }

    public function perform_action_file($action)
    {
        return CLASS_D . "legend/meihuashou/" . $action;
    }
}
