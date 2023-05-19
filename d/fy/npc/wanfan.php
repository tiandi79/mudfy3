<?php
/**
*   wanfan
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;

class wanfan extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '卖玩具的');
        $this->set('id', 'wanfan');
        $this->set('age', 60);
        $this->set('gender', '男性');
        $this->set('long', '一个让孩子们一见就觉得可亲的老翁．');
        $this->set('combat_exp', 5);
        $this->set("attitude", "friendly");
        $this->set("chat_chance", 1);
        $this->set("chat_msg", array('卖玩具的晃了晃手中的玩具，笑道：来，试试．'));
        $this->equip_object('/obj/obj/cloth');

        $this->set("vendor_goods", array("d/fy/npc/obj/windche" => 15,
		    "d/fy/npc/obj/niren" => 20));
    }
}
