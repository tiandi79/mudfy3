<?php
/**
*   年青人
*
*/
namespace d\fy\npc;

use std\char;

class youngman extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '年青人');
        $this->set('id', 'youngman');
        $this->set('age', 15);
        $this->set('gender', '女性');
        $this->set('long', '一个单身的年青人，正盼着桃花运的降临。');
        $this->set("combat_exp", 1000);
	    $this->set("attitude", "friendly");
	    $this->set("per",30);
	    $this->set_skill("unarmed",20);
	    $this->set_skill("parry",20);
        $this->set_skill("dodge",20);
        $this->equip_object('/obj/obj/cloth');
        $this->add_money("gold", 1);
    }
}
