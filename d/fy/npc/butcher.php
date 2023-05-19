<?php
/**
*   大胡子
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;

class butcher extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '大胡子');
        $this->set('id', 'butcher');
        $this->set('age', 32);
        $this->set('title', '屠记肉铺');
        $this->set('gender', '男性');
        $this->set('long', '一个满脸大胡子，和横肉的家伙。');
        $this->set("combat_exp", 25000);
        $this->set("str", 27);
        $this->set("cor", 26);
        $this->set("cps", 25);
        $this->set_skill('unarmed', 200);
	    $this->set("attitude", "heroism");
        $this->set("vendor_goods", array('d/fy/npc/obj/yangtou' => 10,
            'd/fy/npc/obj/zhutou' => 10,
            'd/fy/npc/obj/niutou' => 10));
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
                    msg::message('vision', '大胡子咧开大嘴, 笑着道：这位' . $RANK_D->query_respect($me) . '，要买肉是吗?', $this, $me);
                    break;
            }     
        }
    }

    public function do_spare($ob, $arg = null)
    {
        $ob->ssend(OPENSOON);
        return true;
    }
}
