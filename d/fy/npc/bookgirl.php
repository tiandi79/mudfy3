<?php
/**
*   雅芳
*
*/
namespace d\fy\npc;

use std\char;

class bookgirl extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '雅芳');
        $this->set('id', 'yafang');
        $this->set('age', 9);
        $this->set('gender', '女性');
        $this->set("title", "小书童");
        $this->set('long', '天真的小书童正在整理房间。');
        $this->set('combat_exp', 700);
        $this->set("attitude", "friendly");
        $this->set_skill("unarmed", 10);
        $this->set_skill("parry", 25);
	    $this->set_skill("dodge", 100);
	    $this->set_skill("throwing", 50);
	    $this->set("max_kee", 400);
	    $this->set("eff_kee", 400);
	    $this->set("kee", 400);
        $this->equip_object('/obj/obj/cloth');
        $this->equip_object('/d/fy/npc/obj/flower');
    }
}
