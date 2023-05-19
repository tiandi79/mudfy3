<?php
/**
*   瞎子
*
*/
namespace d\fy\npc;

use std\char;

class daniu extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '瞎子');
        $this->set('id', 'daniu');
        $this->set('age', 32);
        $this->set('gender', '男性');
        $this->set('long', '这是个正在寻视银钩赌坊的保镖。');
        $this->set("combat_exp", 100000);
        $this->set("str", 27);
        $this->set("cor", 26);
        $this->set("cps", 25);
	    $this->set("attitude", "heroism");
	    $this->set_skill("unarmed", 70 + rand(0, 100));
	    $this->set_skill("parry", 70 + rand(0, 100));
        $this->set_skill("dodge", 70 + rand(0, 100));
        $this->set_skill("move", 100 + rand(0, 100));
        $this->set_temp("apply/attack", 70);
        $this->set_temp("apply/defense", 70);
        $this->set_temp("apply/damage", 30);
        $this->set_temp("apply/armor", 70);
        $this->set_temp("apply/move", 100);
        $this->equip_object('/obj/obj/cloth');
    }
}
