<?php
/**
*   方玉香
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;

class fangyuxiang extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '方玉香');
        $this->set('id', 'xiang');
        $this->set('age', 16);
        $this->set('gender', '女性');
        $this->set('long', '这位美人是银鹞子方玉飞的妹妹。');
        $this->set('title', 'HIW银燕子NOR');
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

    public function accept_object($me, $obj)
    {
        if ($obj->query('name') == '罗刹牌') {
            global $DEFAULT_CONN, $RANK_D, $OBJECT;
            $DEFAULT_CONN->init($this);
            $this->do_cmd($DEFAULT_CONN, 'say 多谢这位' . $RANK_D->query_respect($me) . '，你帮了我大忙．这个给你。');
            $me->del_mark('冷若霜');
            $real = $OBJECT->create_objects('/d/fy/npc/obj/realjade');
            if (!$me->get_story('罗刹牌'))
            {
                $me->set_story('罗刹牌');
                $me->add("score", 300);
            }
            if ($real)
                $real->move($me);
            return true;
        }
        return false;
    }
}
