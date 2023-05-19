<?php
/**
*   朱笔判官
*
*/
namespace d\death\npc;

use std\msg;
use std\char;

class panguan extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '朱笔判官');
        $this->set('id', 'panguan');
        $this->set('gender', '男性');
        $this->set('long', '阎王身边的朱笔判官，专勾画天下人的生死。');
        $this->set("str", 36);
        $this->set("cor", 24);
        $this->set("cps", 11);
        $this->set("per", 27);
        $this->set("int", 27);
	    $this->set("agi", 30);
        $this->set('age', 217);
        $this->set("attitude", "peaceful");
        $this->set("chat_chance", 15);
        $this->set("chat_msg", array('判官喝道：牛头，马面何在？'));
        $this->set("combat_exp", 20000);
        $this->set("max_gin", 900);
        $this->set("gin", 900);
        $this->set("max_kee", 900);
        $this->set("kee", 900);
        $this->set("max_sen", 200);
        $this->set("sen", 200);	    
	    $this->set_skill("dodge", 40);
	    $this->set_skill("unarmed", 40);
        $this->equip_object('d/death/npc/obj/tiesuo');
    }
}
