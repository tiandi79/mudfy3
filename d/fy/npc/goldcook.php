<?php
/**
*   大厨
*
*/
namespace d\fy\npc;

use std\char;

class goldcook extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '大厨');
        $this->set('id', 'cook');
        $this->set('age', 42);
        $this->set('gender', '男性');
        $this->set('long', '这是一个手艺精湛的大厨。');
        $this->set("combat_exp", 1000);
	    $this->set("attitude", "heroism");
	    $this->set_skill("unarmed", 130);
	    $this->set_skill("dodge", 30);
        $this->set_skill("parry", 30);
        $this->add_money("gold", 1);
        $this->equip_object('/d/fy/npc/obj/jinzhuang');
        $this->carry_object('/d/fy/npc/obj/luwei');
    }
}
