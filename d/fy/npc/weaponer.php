<?php
/**
*   诸葛雷
*
*/
namespace d\fy\npc;

use std\vendor;

class weaponer extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '诸葛雷');
        $this->set('id', 'zhuge');
        $this->set('age', 31);
        $this->set('gender', '男性');
        $this->set("title", "HIG急风剑NOR");
        $this->set('long', '金狮镖局的大镖头，手底下还可以。');
        $this->set('combat_exp', 500000);
        $this->set("attitude", "friendly");
        $this->set("per", 30);
        $this->set_skill("sword", 50);
	    $this->set_skill("sixchaossword", 50);
	    $this->set_skill("pyrobatsteps", 50);
	    $this->set_skill("dodge", 50);
	    $this->set_skill("parry", 50);
	    $this->map_skill("dodge", "pyrobatsteps");
	    $this->map_skill("parry", "sixchaossword");
	    $this->map_skill("sword", "sixchaossword");
        $this->equip_object('/d/fy/npc/obj/jinzhuang');
        $this->equip_object('/obj/obj/longsword');
        $this->set("vendor_goods", array("/d/fy/npc/obj/purpleflower" => 10,
		    "/d/fy/npc/obj/redflower" => 10,
		    "/d/fy/npc/obj/yellowflower" => 10,
            "/d/fy/npc/obj/blueflower" => 10,
            "/d/fy/npc/obj/whiteflower" => 10,
            "/d/fy/npc/obj/blackflower" => 10));
    }
}
