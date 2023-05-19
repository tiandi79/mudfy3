<?php
/**
*   drugseller
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;

class drugseller extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '卖药的');
        $this->set('id', 'drugseller');
        $this->set('age', 30);
        $this->set('gender', '男性');
        $this->set('long', '一个普生堂的卖药的的伙计．');
        $this->set('combat_exp', 5);
        $this->set("attitude", "friendly");
        $this->set("chat_chance", 1);
        $this->set("chat_msg", array('卖药的高叫道：喔～～～云南白药～～',
            '卖药的高叫道：喔～～～虎骨丸～～',
            '卖药的高叫道：喔～～～大风丸～～'));
        $this->equip_object('/obj/obj/cloth');

        $this->set("vendor_goods", array("/d/fy/npc/obj/sendrug" => 11,
		    "/d/fy/npc/obj/keedrug" => 30,
		    "/d/fy/npc/obj/gindrug" => 11));
    }
}
