<?php
/**
*   考生
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;

class student extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '考生');
        $this->set('id', 'student');
        $this->set("age", 12);
        $this->set("gender", "男性" );
        $this->set('long', '这是一位正在考试的考生。');
        $this->set("combat_exp", 50000);
        $this->set("attitude", "friendly");
        $this->set_skill("hammer", 90);
	    $this->set_skill("dodge", 100); 
        $this->set("ironcloth", 200);
        $this->set("chat_chance", 1);
        $this->set('chat_msg', array('考生抬起头，四下望了一眼．．．'));
        $this->add_money("silver", 1);
        $this->equip_object('/d/fy/npc/obj/fycloth');
    }    
}
