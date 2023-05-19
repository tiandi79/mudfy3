<?php
/**
*   媒婆
*
*/
namespace d\fy\npc;

use std\char;

class meipo extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '媒婆');
        $this->set('id', 'meipo');
        $this->set('age', 42);
        $this->set('gender', '女性');
        $this->set('long', '一位精明能干的老媒婆。');
        $this->set('combat_exp', 10005);
        $this->set("attitude", "friendly");
        $this->set_skill('dodge', 500);
        $this->set_skill('unarmed', 300);
        $this->equip_object('/obj/obj/cloth');
    }

    public function do_marry($ob, $arg)
    {
        $ob->ssend(OPENSOON);
        return true;
    }

    public function do_divorce($ob, $arg)
    {
        $ob->ssend(OPENSOON);
        return true;
    }   
}
