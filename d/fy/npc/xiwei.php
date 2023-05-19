<?php
/**
*   钦卫
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;

class xiwei extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '钦卫');
        $this->set('id', 'qinwei');
        $this->set("age", 25);
        $this->set("gender", "男性" );
        $this->set('long', '一群如狼似虎的钦派护卫。');
        $this->set("combat_exp", 1000000 + rand(0, 500000));
        $this->set_skill("unarmed", 70 + rand(0, 200));
        $this->set_skill("parry", 70 + rand(0, 200));
        $this->set_skill("dodge", 70 + rand(0, 200));
        $this->set_skill("move", 100 + rand(0, 200));
        $this->set("attitude", "heroism");
        $this->set_temp("apply/attack", 70);
        $this->set_temp("apply/defense", 70);
        $this->set_temp("apply/damage", 30 + rand(0, 100));
        $this->set_temp("apply/armor", 70);
        $this->set_temp("apply/move", 100);
        $this->set("chat_chance", 1);
        $this->set('chat_msg', array('钦卫号道：风平．．．．．浪静．．．．．．'));

        $this->equip_object('/obj/obj/cloth');
    }    
}
