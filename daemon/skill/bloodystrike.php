<?php
/**
*   少林长拳
* 
*/
namespace daemon\skill;

class bloodystrike
{
    public $actions, $parry_msg, $unarmed_parry_msg;

    function __construct()
    {
        $this->unarmed_parry_msg = array('$n步走阴阳，一招「我佛慈悲怀」虚空拍出三掌，逼得$N撤招自保。',
            '$n施展出「万象皆归空」，轻描淡写的化解了$N的攻势。');
        $this->parry_msg = array('$n双掌微合，使出一招「千里迎刹佛」，「啪」的一声将$N的$w夹在双掌之间。',
            '$n略一转身，一招「撒手离红尘」拍向$N拿着$w的手。',
            '$n使出「粘」字诀，双掌一划，引偏了$N的$w。');
        $this->actions = array(array('action' => '$N使出一招「苦海端无涯」，左掌虚幌，右掌穿出击向$n的$l', 'dodge' => -100, 'force' => 100, 'parry' => 100, 'damage_type' => '瘀伤'),
            array('action' => '$N使出一招「地狱似有门」，左掌化虚为实击向$n的$l', 'dodge' => -100, 'force' => 70, 'parry' => 100, 'damage_type' => '瘀伤'),
            array('action' => '$N使出密宗大手印中的「天堂却无路」，一掌拍向$n的$l', 'dodge' => -100, 'force' => 50, 'parry' => 100, 'damage_type' => '瘀伤'),
            array('action' => '$N双掌一错，使出「密宗为独尊」，对准$n的$l连续拍出', 'dodge' => -100, 'force' => 150, 'parry' => 100, 'damage_type' => '瘀伤'),
            array('action' => '$N左掌立于胸前，右掌推出，一招「万念皆是空」击向$n$l', 'dodge' => -100, 'force' => 140, 'parry' => 100, 'damage_type' => '瘀伤'),
            array('action' => '$N使出「佛云以杀止杀」，身形凌空飞起，从空中当头向$n的$l出掌攻击', 'dodge' => -150, 'force' => 200, 'parry' => 200, 'damage_type' => '瘀伤'));
    }

    public function valid_learn($me = null)
    {
        if ($me->query_temp('weapon') != null || $me->query_temp('second_weapon') != null) {
            $me->get_conn()->ssend('练密宗大手印必须空手。');
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
        return '密宗大手印';
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
        return 10;
    }

    public function practice_bonus()
    {
        return 5;
    }
    
    public function black_white_ness()
    {
        return 100;
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
        return 6;
    }

    public function perform_action_file($action)
    {
        return CLASS_D . "lama/bloodystrike/" . $action;
    }
}
