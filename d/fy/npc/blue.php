<?php
/**
*   蓝胡子
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;

class blue extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '蓝胡子');
        $this->set('id', 'lang');
        $this->set('age', 29);
        $this->set('gender', '男性');
        $this->set('long', '蓝胡子是银钩赌坊的大老板。');
        $this->set('title', 'HIB银钩赌坊大老板NOR');
        $this->set("combat_exp", 100000);
        $this->set("str", 27);
        $this->set("cor", 26);
        $this->set("cps", 25);
        $this->set("per", 30);
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
        $this->set("chat_chance", 1);
        $this->set("chat_msg", array('蓝胡子叹道：罗刹牌被李霞偷到老屋，西方魔教又惹不起，只好找替死鬼。'));
        $this->equip_object('d/fy/npc/obj/yincloth');
    }
}
