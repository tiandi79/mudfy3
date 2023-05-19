<?php
/**
*   dtz
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;
use \Workerman\Lib\Timer;

class dtz extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '登徒子');
        $this->set('id', 'dtz');
        $this->set('age', 32);
        $this->set('gender', '男性');
        $this->set('long', '一个色迷迷的登徒子。');
        $this->set("combat_exp", 1000);
        $this->set("attitude", "heroism");
        $this->set_skill("unarmed", 20);
        $this->set_skill("parry", 20);
	    $this->set_skill("dodge", 20);
        $this->set("chat_chance", 15);
        $this->add_money("silver", 1);
        $this->equip_object('/obj/obj/cloth');
    }
}
