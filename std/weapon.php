<?php
/**
*   武器类
*
*/
namespace std;

class weapon extends obj
{
    public $actions, $weapon_actions;
    function __construct()
    {
        parent::__construct();

        $this->id = 'weapon';
        $this->name = '未命名武器';
        $this->weight = 1;
        $this->unit = '件';
        $this->material = 'steel';
        $this->weapon_prop = 1;
        $this->type = 'sword';
        $this->weapon_actions = array('slash' => array('damage_type' => '割伤', 'action' => '$N挥动$w，斩向$n的$l', 'parry' => 20),
            'slice' => array('damage_type' => '砍伤', 'action' => '$N用$w往$n的$l砍去', 'dodge' => 20),
            'chop' => array('damage_type' => '劈伤', 'action' => '$N的$w朝著$n的$l劈将过去', 'parry' => -20),
            'hack' => array('damage_type' => '砍伤', 'action' => '$N挥舞$w，对准$n的$l一阵乱砍', 'dodge' => 30, 'damage' => 30),
            'thrust' => array('damage_type' => '刺伤', 'action' => '$N用$w往$n的$l刺去', 'dodge' => 15, 'parry' => -15),
            'pierce' => array('damage_type' => '刺伤', 'action' => '$N的$w往$n的$l狠狠地一捅', 'dodge' => -30, 'parry' => -30),
            'whip' => array('damage_type' => '鞭伤', 'action' => '$N将$w一扬，往$n的$l抽去', 'dodge' => -20, 'parry' => 30),
            'impale' => array('damage_type' => '刺伤', 'action' => '$N用$w往$n的$l直戳过去', 'dodge' => -10, 'parry' => -10),
            'bash' => array('damage_type' => '挫伤', 'action' => '$N挥舞$w，往$n的$l用力一砸', 'post_action' => 'bash_weapon'),
            'crush' => array('damage_type' => '挫伤', 'action' => '$N高高举起$w，往$n的$l当头砸下', 'post_action' => 'bash_weapon'),
            'slam' => array('damage_type' => '挫伤', 'action' => '$N手握$w，眼露凶光，猛地对准$n的$l挥了过去', 'post_action' => 'bash_weapon'),
            'throw' => array('damage_type' => '刺伤', 'action' => '$N将$w对准$n的$l射了过去', 'post_action' => 'throw_weapon'),
            );
    }

    public function query_action()
    {
        $verbs = $this->query('verbs');

        if (!isset($verbs)) 
            return $this->weapon_actions['slice'];
        else {
            $verb = $verbs[rand(0, count($verbs) - 1)];
            if (isset($this->weapon_actions[$verb])) 
                return $this->weapon_actions[$verb];
            else 
                return $this->weapon_actions['slice'];
        }       
    }

    public function throw_weapon($me, $victim)
    {
        if ($this->query_amount() == 1) {
            $me->unequip($this);
            if ($me->is_player())
                $me->get_conn()->ssend('你的' . $this->query('name') . '用完了！');
            }
        $this->add_amount(-1);
    }

    public function bash_weapon($me, $victim, $damage)
    {
        $myweapon = $me->query_temp('weapon');
        $yourweapon = $victim->query_temp('weapon');
        if ($myweapon && $damage == RESULT_PARRY && $yourweapon) {
            $wap = intval($myweapon->query_weight() / 500) + intval($myweapon->query("rigidity")) + intval($me->query_attr('str') * 10);
            $wdp = intval($yourweapon->query_weight() / 500) + intval($yourweapon->query("rigidity")) + intval($victim->query_attr('str') * 10);
            $wap = rand(0, $wap);
                if ($wap > 2 * $wdp ) {
                    msg::message('vision', 'HIW只听见「啪」地一声，$N手中的' . $yourweapon->query('name') . '已经断为两截！NOR', $victim);
                    $victim->unequip($yourweapon);
                    $yourweapon->set("name", "断掉的" . $yourweapon->query("name"));
                    $yourweapon->set("value", 0);
                    $yourweapon->set("weapon_prop", 0);
			        $yourweapon->set("no_get", 0);
			        $yourweapon->set("no_drop", 0);
                    $victim->reset_action();
                } elseif ($wap > $wdp / 2 ) {
                    msg::message('vision', '$N只觉得手中' . $yourweapon->query('name') . '一震，险些脱手！', $victim);
                } else {
                    msg::message('vision', '$N的' . $myweapon->query('name') . '和$n的' . $yourweapon->query('name') . '相击，冒出点点的火星。', $me, $victim);
                }
        }
    }
}
