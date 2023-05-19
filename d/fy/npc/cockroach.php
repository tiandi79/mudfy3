<?php
/**
*   大蟑螂
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;

class cockroach extends char
{
    public $name = array('大蟑螂', '小蟑螂');
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', $this->name[rand(0, count($this->name) - 1)]);
        $this->set('id', 'cockroach');
        $this->set("race", "野兽");
        $this->set("age", 1);
        $this->set('long', '一只非常恶心的蟑螂。');
        $this->set("combat_exp", 7000);
	    $this->set("attitude", "heroism");
	    $this->set_skill("unarmed", 100);
	    $this->set_skill("dodge", 200);
        $this->set('can_speak', false);
        $this->set("arrive_msg", "飞快地爬了过来");
        $this->set("leave_msg", "飞快地爬开了");
        $this->set("limbs", array("头部", "身体"));
        $this->set("verbs", array("bite" ));
        $this->set_temp("armor", 50);
        $this->set("chat_chance", 25);
        $this->set("chat_msg", array(':hide'));
    }

    public function hide()
    {
        if ($this->get_env() == null) 
            return false;
        msg::message("vision", "蟑螂爬著爬著钻进墙边的裂缝了。", $this);
        $this->destruct();
        return true;
    }
}
