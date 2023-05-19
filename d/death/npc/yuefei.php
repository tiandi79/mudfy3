<?php
/**
*   岳飞
*
*/
namespace d\death\npc;

use std\msg;
use std\char;

class yuefei extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '常胜将军');
        $this->set('id', 'yue');
        $this->set('gender', '男性');
        $this->set('nickname', 'HIY金盔NORHIW银甲NOR');
        $this->set('long', '你看着看着，觉得这位将军就象是当年统兵十万，直捣黄龙，壮志未酬的岳飞！');
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
	    $this->set_skill("manjianghong", 80);
        $this->set_skill("literate", 60);
	    $this->map_skill("force", "manjianghong");
        $this->set("skill_public", 1);
	    $this->set_temp("apply/attack", 200);
	    $this->set_temp("apply/defense", 200);
        $this->equip_object('d/death/npc/obj/goldarmor');
        $this->equip_object('d/death/npc/obj/silverarmor');
        $this->is_ghost = true;
    }

    public function recognize_apprentice($me)
    {
        if (!$me->get_mark('忠义'))
            return false;
        elseif ($me->get_mark('忠义') == '不忠')
	    {
		    msg::message_message('vision', '将军喝道：我最恨的就是你这种不忠之人！', $this);
		    $this->kill_ob($me);
		    $me->kill_ob($this);
		    return false;
        }elseif ($me->get_mark('忠义') == '忠')
            return true;
        else
            return false;
    }
}
