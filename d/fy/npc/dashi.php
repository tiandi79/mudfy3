<?php
/**
*   乙成仙
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;

class dashi extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '乙成仙');
        $this->set('id', 'xian');
        $this->set('age', 45);
        $this->set('title', 'HIY生死已卜NOR');
        $this->set('gender', '男性');
        $this->set('long', '这位＂生死已卜＂的乙成仙正满眼诡密的望着你。');
        $this->set("combat_exp", 500000);
        $this->set("str", 27);
        $this->set("cor", 26);
        $this->set("cps", 25);
	    $this->set("attitude", "friendly");
        $this->set_skill("unarmed",250);
	    $this->set("force", 10000);
	    $this->set("max_force", 10000);
	    $this->set("force_factor", 50);
	    $this->set_skill("dodge", 50);
        $this->equip_object('/d/fy/npc/obj/daopao');
    }

    public function init_coming($me)
    {
        if (!$this->is_fighting()) {
            $this->call_out(1, 'greating', $me);
        }
    }

    public function greating($me)
    {
        $this->timerid = null;
        if ($me->is_player() && $this->is_environment($me->query('id'))) {
            $i = rand(0, 10);
            switch($i) {
                case 0:
                    msg::message('vision', '$N向$n说道：你印堂发黑，刹气透天庭，三天！三天之内一定横尸街头。', $this, $me);
                    break;
                case 1:
                    msg::message('vision', '$N对$n阴笑一声：你还是去订口棺材吧！', $this, $me);
                    break;
            }
            
        }
    }
}
