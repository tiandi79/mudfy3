<?php
/**
*   风云衙役
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;

class yayi extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '风云衙役');
        $this->set('id', 'yayi');
        $this->set("age", 22);
        $this->set("gender", "男性" );
        $this->set('long', '正在上堂的衙役，千万不要惹他们。');
        $this->set("pursuer", 1);
        $this->set("combat_exp", 500000);
        $this->set("attitude", "heroism");
        $this->set("vendetta_mark", "authority");
        $this->set_skill("unarmed", 70 + rand(0, 200));
        $this->set_skill("staff", 70 + rand(0, 200));
        $this->set_skill("parry", 70 + rand(0, 200));
        $this->set_skill("dodge", 70 + rand(0, 200));
        $this->set_skill("move", 100 + rand(0, 200));

        $this->set_temp("apply/attack", 70);
        $this->set_temp("apply/defense", 70);
        $this->set_temp("apply/damage", 30 + rand(0, 100));
        $this->set_temp("apply/armor", 70);
        $this->set_temp("apply/move", 100);
        $this->set("chat_chance", 1);
        $this->set('chat_msg', array('风云衙役低声宣道：威～～～～武～～～～'));

        $this->equip_object('/d/fy/npc/obj/yafu');
        $this->equip_object('/d/fy/npc/obj/sawei');
    }    
}
