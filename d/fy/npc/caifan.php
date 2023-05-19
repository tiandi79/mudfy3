<?php
/**
*   caifan
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;

class caifan extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '卖菜的');
        $this->set('id', 'caifan');
        $this->set('age', 40);
        $this->set('gender', '男性');
        $this->set('long', '一个为生活而终日奔波的小商人．');
        $this->set('combat_exp', 5);
        $this->set("attitude", "friendly");
        $this->set("rank_info/respect", "老二哥");
        $this->set("chat_chance", 3);
        $this->set("chat_msg", array('卖菜的笑道：那一招天外飞仙，七搏一赌叶孤城胜．．'));

        $this->set("vendor_goods", array("d/fy/npc/obj/smallvege" => 11,
		    "d/fy/npc/obj/midvege" => 22,
		    "d/fy/npc/obj/bigvege" => 22));
    }
}
