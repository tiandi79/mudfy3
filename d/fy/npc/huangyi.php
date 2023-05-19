<?php
/**
*   黄衣卫
*
*/
namespace d\fy\npc;

use std\char;

class huangyi extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '黄衣卫');
        $this->set('id', 'guard');
        $this->set('age', 32);
        $this->set('gender', '男性');
        $this->set('long', '这是一位金钱帮总舵的黄衣卫。');
        $this->set("combat_exp", 50000);
	    $this->set("attitude", "friendly");
	    $this->set_skill("sword", 90 + rand(0, 100));
	    $this->set_skill("dodge", 100);
        $this->set_skill("ironcloth", 200);
        $this->set("chat_chance", 1);
        $this->add_money("silver", 5);
        $this->set("chat_msg", array('黄衣卫向你喝道：口令？？',
            '黄衣卫向你喝道：站住．亮你的腰牌？'));
        $this->equip_object('/d/fy/npc/obj/tangfu');
        $this->equip_object('/obj/obj/longsword');
    }
}
