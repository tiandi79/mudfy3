<?php
/**
*   楚楚
*
*/
namespace d\fy\npc;

use std\char;

class smilegirl extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '楚楚');
        $this->set('id', 'chuchu');
        $this->set('age', 18);
        $this->set('gender', '女性');
        $this->set('long', '一个天真无邪，未懂世事的小丫环。');
        $this->set("combat_exp", 500000);
	    $this->set("attitude", "friendly");
	    $this->set("per",30);
	    $this->set_skill("unarmed", 5);
	    $this->set_skill("tenderzhi", 5);
	    $this->set_skill("dodge", 5);
	    $this->set_skill("stormdance", 5);
	    $this->map_skill("dodge", "stormdance");	
	    $this->map_skill("unarmed", "tenderzhi");
        $this->equip_object('/d/fy/npc/obj/greencloth');
    }
}
