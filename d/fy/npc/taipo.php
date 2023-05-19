<?php
/**
*   上了年纪的老太婆
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;

class taipo extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '上了年纪的老太婆');
        $this->set('id', 'taipo');
        $this->set('age', 99);
        $this->set('gender', '女性');
        $this->set('long', '风云城中最老的老太婆，风云老小都很尊重她。');
        $this->set('combat_exp', 5);
        $this->set("str", 27);
        $this->set("cor", 26);
        $this->set("cps", 25);
        $this->set("attitude", "friendly");
        $this->equip_object('/obj/obj/cloth');
    }

    public function do_work($ob, $arg = null)
    {
        $me = $ob->body;
        if ($me->is_busy()) {
            $ob->ssend('你的动作还没有完成，不能工作。');
            return true;
        }

        msg::message('vision', '$N辛苦的工作终于结束了，可人也累的要死。', $me);
        $me->receive_damage('gin', 30);
        $me->receive_damage('sen', 30);
        global $OBJECT;
        $obj = $OBJECT->create_objects('/obj/money/silver');
        $obj->move($me);
        msg::message('vision', '上了年纪的老太婆对$N说：这是你的工钱。', $me);
        $me->start_busy(1);
        return true;
    }   
}
