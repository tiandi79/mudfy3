<?php
/**
*   伙计
*
*/
namespace d\fy\npc;

use std\char;

class huoji extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '伙计');
        $this->set('id', 'huoji');
        $this->set('age', 22);
        $this->set('gender', '男性');
        $this->set('long', '这个伙计正在手忙脚乱的往镖车上装载货物。');
        $this->set("combat_exp", 1000);
	    $this->set("attitude", "heroism");
	    $this->set_skill("unarmed", 10);
	    $this->set_skill("dodge", 10);

        $this->add_money("silver", 1);
        $this->equip_object('/d/fy/npc/obj/jinzhuang');
    }
}
