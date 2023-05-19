<?php
/**
*   关二爷
*
*/
namespace d\death\npc;

use std\msg;
use std\char;

class guan extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '关二爷');
        $this->set('id', 'yue');
        $this->set('gender', '男性');
        $this->set('long', '上马金，下马银，不能改其义，千里送嫂，过五关斩六将的关二爷！');
        $this->set("age", 44);
        $this->set("str", 50);
        $this->set("cor", 30);
        $this->set("cps", 30);
        $this->set("int", 30);
	    $this->set("per", 30);
	    $this->set("attitude","friendly");
        $this->set("max_force", 15000);
        $this->set("force", 15000);
        $this->set("force_factor", 20);
        $this->set("combat_exp", 1000000);
        $this->set("agi",25);
        $this->set_skill("move", 70);
        $this->set_skill("parry", 80);
        $this->set_skill("dodge", 80);
        $this->set_skill("force", 80);
        $this->set_skill("literate", 60);
	    $this->set_temp("apply/attack",200);
	    $this->set_temp("apply/defense",200);
        $this->equip_object('/obj/obj/cloth');
        $this->is_ghost = true;
    }
}
