<?php
/**
*   小公子
*
*/
namespace d\fy\npc;

use std\char;

class prince extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '小公子');
        $this->set('id', 'prince');
        $this->set("age", 12);
        $this->set("gender", "男性" );
        $this->set('long', '这是当今皇上的小公子，最受宠爱的一个。');
        $this->set("combat_exp", 5000);
        $this->set("attitude", "friendly");
        $this->set_skill("dodge", 100);
	    $this->set_skill("leadership", 300);
	    $this->set_skill("strategy", 300);

	    $this->set("class","official");
        $this->set("chat_chance", 1);
        $this->set('chat_msg', array('"小公子信口道：狂HIR风NOR一翻滚，何处不是HIG云NOR'));
        $this->set("chat_chance_combat", 90);
        $this->set("chat_msg_combat", array('alert'));
        $this->add_money("gold", 5);
        $this->equip_object('/d/fy/npc/obj/fycloth');
    }    
}
