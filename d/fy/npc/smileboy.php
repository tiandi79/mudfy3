<?php
/**
*   金童
*
*/
namespace d\fy\npc;

use std\char;

class smileboy extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '金童');
        $this->set('id', 'jintong');
        $this->set('age', 14);
        $this->set('gender', '男性');
        $this->set('long', '一个天真无邪，未懂世事的小金童。');
        $this->set("combat_exp", 500000);
	    $this->set("attitude", "friendly");
	    $this->set("per",30);
	    $this->set_skill("unarmed", 5);
	    $this->set_skill("tenderzhi", 5);
	    $this->set_skill("dodge", 5);
	    $this->set_skill("stormdance", 5);
	    $this->map_skill("dodge", "stormdance");	
	    $this->map_skill("unarmed", "tenderzhi");
        $this->equip_object('/d/fy/npc/obj/yellowcloth');
    }
}
