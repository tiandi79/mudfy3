<?php
/**
*   普生
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;

class hosowner extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '普生');
        $this->set('id', 'pusheng');
        $this->set('age', 32);
        $this->set('title', 'GRN赛华陀NOR');
        $this->set('gender', '男性');
        $this->set('long', '这位普生堂老板武功，医道精湛。救死扶伤无数。');
        $this->set("combat_exp", 500000);
        $this->set("str", 27);
        $this->set("cor", 26);
        $this->set("cps", 25);
        $this->set_skill('unarmed', 50);
        $this->set_skill('changquan', 150);
        $this->set_skill('dodge', 150);
        $this->map_skill("unarmed", "changquan");
	    $this->set("attitude", "friendly");
        $this->set("vendor_goods", array('d/fy/npc/obj/sendrug' => 10,
            'd/fy/npc/obj/keedrug' => 10,
            'd/fy/npc/obj/gindrug' => 10));
        $this->equip_object('/d/fy/npc/obj/fycloth');
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
            global $RANK_D;
            $i = rand(0, 10);
            switch($i) {
                case 0:
                    msg::message('vision', '$N望了$n一眼，低声说道：你面黄肌瘦，肾水亏空，是否．．．过度？', $this, $me);
                    break;
            }     
        }
    }
}
