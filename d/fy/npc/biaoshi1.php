<?php
/**
*   趟子手
*
*/
namespace d\fy\npc;

use std\char;

class biaoshi1 extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '趟子手');
        $this->set('id', 'tang');
        $this->set('age', 32);
        $this->set('gender', '男性');
        $this->set('long', '这是一位体态轻盈的趟子手。');
        $this->set("combat_exp", 50000);
	    $this->set("attitude", "friendly");
	    $this->set_skill("hammer", 90);
	    $this->set_skill("dodge", 100);
        $this->set("ironcloth", 200);
        $this->add_money("silver", 50);
        $this->set_skill("unarmed", 90);
	    $this->set_skill("dodge", 100);
        $this->add_money("silver", 50);
        $this->set("chat_chance", 5);
        $this->set("chat_msg", array('趟子手又在一人多高的梅花桩上练习了一遍。'));
        $this->equip_object('/d/fy/npc/obj/jinzhuang');
    }
}
