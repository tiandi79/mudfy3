<?php
/**
*   冷若霜
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;

class leng extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '冷若霜');
        $this->set('id', 'leng');
        $this->set('age', 19);
        $this->set('gender', '女性');
        $this->set('long', '这位美人人如其名，给人一种高不可攀，冷若冰霜的感觉．但她是太有媚力，太令人着迷，你真想和她认识认识（ｋｎｏｗ）');
        $this->set('title', 'HIW冰山NOR');
        $this->set("combat_exp", 100000);
        $this->set("str", 27);
        $this->set("cor", 26);
        $this->set("cps", 25);
        $this->set("per", 30);
	    $this->set("attitude", "heroism");
	    $this->set_skill("unarmed", 70 + rand(0, 100));
	    $this->set_skill("parry", 70 + rand(0, 100));
        $this->set_skill("dodge", 70 + rand(0, 100));
        $this->set_skill("move", 100 + rand(0, 100));
        $this->set_temp("apply/attack", 70);
        $this->set_temp("apply/defense", 70);
        $this->set_temp("apply/damage", 30);
        $this->set_temp("apply/armor", 70);
        $this->set_temp("apply/move", 100);
        $this->equip_object('d/fy/npc/obj/goldcloth');
    }

    public function do_know($ob, $arg)
    {
        $me = $ob->body;
        if ($me->query("combat_exp") >= 20000) {
            $ob->ssend('冷若霜叹了口气，＂看来今天只好拉你作替死鬼了。"');
            $ob->ssend('冷若霜趁你不备，悄悄拂了一下你的睡穴。');
            $me->unconcious();
            $me->set_mark('冷若霜', 1);
            $me->save();
            
            global $OBJECT;
            $room = $OBJECT->get_room('/d/fy/yingou');
            if ($room)
                $me->move($room, true);
        } else {
            if ($me->query("gender") == "男性")
                msg::message('vision', '$N反反正正打了$n几记大耳光，斥骂道：＂滚开！你这种臭男人我见得多了！看见你都感到恶心！滚！', $this, $me);
        	else
                msg::message('vision', '$N向$n挤出一丝勉强的笑容，道：＂好妹妹！你帮不到我。', $this, $me);
        }
        return true;
    }
}
