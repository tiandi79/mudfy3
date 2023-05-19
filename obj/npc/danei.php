<?php
/**
*   大内高手
*
*/
namespace obj\npc;

use std\msg;
use std\char;

class danei extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '大内高手');
        $this->set('id', 'guard');
        $this->set("age", 25);
        $this->set("gender", "男性" );
        $this->set('long', '这是一位大内高手，专门担任保护之责。');

        $this->set("max_atman", 100);
	    $this->set("atman", 100);
	    $this->set("max_mana", 100);
	    $this->set("mana", 100);
	    $this->set("str", 40);
	    $this->set("cor", 30);
	    $this->set("cps", 25);
	    $this->set("combat_exp", 100000);
	    $this->set_skill("sword", 70);
	    $this->set_skill("parry", 70);
	    $this->set_skill("dodge", 70);
	    $this->set_skill("move", 70);

        $this->equip_object('/obj/obj/cloth');
        $this->equip_object('/obj/obj/longsword');
    }   
    
    public function heal_up()
    {
        if ($this->query_temp('removing') == null) {
            $this->call_out(5, 'remove_object', 0);
            $this->set_temp('removing', 1);
        }
    }

    public function remove_object($nouse = null)
    {
        $this->del_temp('removing');
        $env = $this->get_env();
        msg::message('vision', $this->query('name') . '说道：如再有变化，发哨为警！<br>' . $this->query('name') . '闪了闪就消失不见了。', $this);
        $owner = $this->query('possessed');
        if ($owner) 
            $owner->add_temp('max_guard', -1);
        $this->destruct();
    }

    public function invocation($me, $lv)
    {
        $this->set_skill("sword", 70 + rand(0, $lv / 2));
	    $this->set_skill("parry", 70 + rand(0, $lv / 2));
	    $this->set_skill("dodge", 70 + rand(0, $lv / 2));
	    $this->set_skill("move", 70 + rand(0, $lv / 2));
	    $this->set("combat_exp", 100000 + rand(0, $lv / 4 * $lv * $lv));
        msg::message('vision', $this->query('name') . '喝道：大胆！竟敢和朝廷命官过不去！', $this);
        $enemy = $me->query_enemy();
        $i = count($enemy);
        while ($i--) {
            if ($enemy[$i] && $enemy[$i]->living()) {
			    $this->kill_ob($enemy[$i]);
			    if ($enemy[$i]->is_player()) 
                    $enemy[$i]->fight_ob($this);
			    else 
                    $enemy[$i]->kill_ob($this);
		    }
        }
        $this->set_leader($me);
	    $this->set("possessed", $me);
    }

    public function die()
    {
        $owner = $this->query('possessed');
        if ($owner) 
            $owner->add_temp('max_guard', -1);
        $this->backattack();
        parent::die();
    }

    private function backattack()
    {
        $owner = $this->query('possessed');
        if ($owner) {
            $enemy = $this->query_enemy();
            $i = count($enemy);
            while ($i--) {
                if ($enemy[$i] && $enemy[$i]->living()) {
                    $owner->kill_ob($enemy[$i]);
                    $enemy[$i]->kill_ob($owner);
                }
            }
        }
    }
}
