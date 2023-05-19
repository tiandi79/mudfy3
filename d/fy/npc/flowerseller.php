<?php
/**
*   花满城
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;

class flowerseller extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '花满城');
        $this->set('id', 'huaman');
        $this->set('age', 41);
        $this->set('gender', '男性');
        $this->set("title", "BLU月老NOR");
        $this->set('long', '这位老板正对你露出慈祥的笑容。');
        $this->set('combat_exp', 500000);
        $this->set("attitude", "friendly");
        $this->set("per",30);
        $this->set_skill("unarmed",50);
	    $this->set_skill("dodge",50);
        $this->equip_object('/d/fy/npc/obj/fycloth');
        $this->set("vendor_goods", array("/d/fy/npc/obj/purpleflower" => 10,
		    "/d/fy/npc/obj/redflower" => 10,
		    "/d/fy/npc/obj/yellowflower" => 10,
            "/d/fy/npc/obj/blueflower" => 10,
            "/d/fy/npc/obj/whiteflower" => 10,
            "/d/fy/npc/obj/blackflower" => 10));
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
                    msg::message('vision', '$N笑着说道：各种新鲜花朵，买些回去给你的心上人吧。', $this);
                    break;
                case 1:
                    msg::message('vision', '$N笑咪咪地说道：这位' . $RANK_D->query_respect($me) . '要买什么花儿？', $this, $me);
                    break;
                default:
            }            
        }
    }
}
