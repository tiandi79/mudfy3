<?php
/**
*   大辫子姑娘
*
*/
namespace d\fy\npc;

use std\char;

class younggirl extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '大辫子姑娘');
        $this->set('id', 'younggirl');
        $this->set('age', 14);
        $this->set('gender', '女性');
        $this->set('long', '一个美丽又善良，有一双温柔的大眼睛，辫子粗又长的姑娘。');
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
