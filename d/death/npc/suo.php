<?php
/**
*   缇萦
*
*/
namespace d\death\npc;

use std\msg;
use std\char;

class suo extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '缇萦');
        $this->set('id', 'xiaonu');
        $this->set('gender', '女性');
        $this->set('long', '以孝道而闻名天下的缇萦。');
        $this->set("age", 24);
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
        $this->set("agi", 25);
        $this->set("int", 30);
        $this->set_skill("xiaodao", 200);
        $this->set("skill_public", 1);
	    $this->set_temp("apply/attack", 200);
	    $this->set_temp("apply/defense", 250);
        $this->equip_object('/obj/obj/cloth');
        $this->set('inquiry', array('孝道' => '身体发肤受之父母，养育之恩，有甚于天，不孝之人，鬼神难容。', 'xiaodao' => '身体发肤受之父母，养育之恩，有甚于天，不孝之人，鬼神难容。'));
        $this->is_ghost = true;
    }

    public function recognize_apprentice($me)
    {
        return true;
    }
}
