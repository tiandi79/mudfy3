<?php
/**
*   牛头
*
*/
namespace d\death\npc;

use std\msg;
use std\char;

class niutou extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '牛头');
        $this->set('id', 'niutou');
        $this->set('gender', '男性');
        $this->set('title', 'HIW铁索NOR');
        $this->set('long', '牛面人身，全身青紫的鬼怪。');
        $this->set("str", 36);
        $this->set("cor", 24);
        $this->set("cps", 11);
        $this->set("per", 27);
        $this->set("int", 27);
	    $this->set("agi", 30);
        $this->set_temp("apply/astral_vision", 1);
        $this->set("intellgent",1);
        $this->set("attitude", "peaceful");
        $this->set("chat_chance", 20);
        $this->set("max_force", 3000);
        $this->set("force", 3000);
        $this->set("combat_exp", 9999);
        $this->set_skill("whip", 120);
	    $this->set_skill("dodge", 100);
        $this->equip_object('d/death/npc/obj/tiesuo');
    }

    public function accept_object($me, $ob)
    {
        msg::message('vision', '$N对$n怪叫一声：在阳间做亏心事了吧！', $this, $me);
    }
}
