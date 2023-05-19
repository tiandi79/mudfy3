<?php
/**
*   drugseller
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;

class bookseller extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '读千里');
        $this->set('id', 'duqianli');
        $this->set('age', 81);
        $this->set('gender', '男性');
        $this->set("title", "才高八斗");
        $this->set('long', '这位老板不但才高八斗，而且还是当今皇太子的老师。');
        $this->set('combat_exp', 500000);
        $this->set("attitude", "friendly");
        $this->set("per",30);
        $this->set_skill("unarmed",50);
	    $this->set_skill("dodge",50);
        $this->equip_object('/obj/obj/cloth');
        $this->set("vendor_goods", array("/d/fy/npc/obj/book" => 10,
		    "/d/fy/npc/obj/book3" => 10,
		    "/d/fy/npc/obj/book4" => 10,
            "/d/fy/npc/obj/book5" => 10,
            "/d/fy/npc/obj/book6" => 10,
            "/d/fy/npc/obj/book7" => 10,
            "/d/fy/npc/obj/book8" => 10));
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
                    msg::message('vision', '$N摇头晃脑地低吟道：良时不再至，离别在须臾。屏营衢路侧．．', $this);
                    break;
                case 1:
                    msg::message_text('vision', '$N望了$n一眼，低哼道：结发为夫妻，恩爱两不疑。欢娱在今夕．．', $this, $me);
                    break;
                default:
            }            
        }
    }
}
