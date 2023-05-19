<?php
/**
*   单身趟子手
*
*/
namespace d\fy\npc;

use std\char;

class restingbiao extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '单身趟子手');
        $this->set('id', 'tang');
        $this->set('age', 32);
        $this->set('gender', '男性');
        $this->set('long', '这是一位金狮镖局的趟子手。');
        $this->set("combat_exp", 50000);
	    $this->set("attitude", "friendly");
	    $this->set_skill("unarmed", 90);
	    $this->set_skill("dodge", 100);
        $this->set_skill("ironcloth", 200);
        $this->add_money("silver", 50);
        $this->set("chat_chance", 5);
        $this->set("chat_msg", array('镖师又将手中的石锁一口气连举了七八十下。',
            '镖师望了望自己粗壮的胳膊，又捏了两下，脸上露出得意之色。'));
        $this->equip_object('/d/fy/npc/obj/jinzhuang');
        if (rand(0,2) == 0)
            $this->carry_object("d/fy/npc/obj/huopiao");

    }
}
