<?php
/**
*   账房先生
*
*/
namespace d\fy\npc;

use std\char;

class xiansheng extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '账房先生');
        $this->set('id', 'xiansheng');
        $this->set('age', 42);
        $this->set('gender', '男性');
        $this->set('long', '一个精明能干，武功高强的账房先生。');
        $this->set("combat_exp", 9999999);
	    $this->set("max_atman", 300);
        $this->set("atman", 300);
        $this->set("max_force", 300);
        $this->set("force", 300);
        $this->set("max_mana", 300);
        $this->set("mana", 300);
        $this->set("force_factor", 20);
        $this->set("combat_exp", 9999999);
        $this->set_skill("unarmed", 100);
        $this->set_skill("dodge", 100);
        $this->set_skill("force", 130);
        $this->set_skill("literate", 70);
        $this->set_skill("qidaoforce", 100);
        $this->set_skill("meihuashou", 80);
        $this->set_skill("fallsteps", 100);

        $this->map_skill("unarmed", "meihuashou");
        $this->map_skill("dodge", "fallsteps");
        $this->equip_object('/d/fy/npc/obj/jinzhuang');
    }
}
