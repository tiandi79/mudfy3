<?php
/**
*   青竹先生
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;

class zhu extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '青竹先生');
        $this->set('id', 'zhu');
        $this->set("age", 65);
        $this->set("gender", "男性" );
        $this->set('title', 'HIG岁寒三友NOR');
        $this->set('long', '西方神教的三大护法之一。');
        $this->set("combat_exp", 999999);
        $this->set("str", 6);
        $this->set("cor", 24);
        $this->set("cps", 11);
        $this->set("per", 27);
        $this->set("int", 27);
        $this->set("intellgent",1);
        $this->set("attitude", "peaceful");
        $this->set("max_atman", 300);
        $this->set("atman", 300);
        $this->set("max_force", 3000);
        $this->set("force", 3000);
        $this->set("max_mana", 300);
        $this->set("mana", 300);
        $this->set("chat_chance", 20);
        $this->set('chat_msg', array(':random_move'));

        $this->set_skill("unarmed", 120);
        $this->set_skill("throwing", 100);
	    $this->set_skill("dodge", 100);
        $this->set_skill("force", 130);
        $this->set_skill("demonforce", 100);
        $this->set_skill("demonstrike", 80);
        $this->set_skill("demonsteps", 10);

        $this->map_skill("unarmed", "demonstrike");
        $this->map_skill("dodge", "demonsteps");

        $this->equip_object('/obj/obj/cloth');
        $this->equip_object('d/fy/npc/obj/stone');
    }

    public function init_coming($me)
    {
        if ($me->query('combat_exp') > 2000 && $me->get_mark('冷若霜') != null) {
            msg::message('vision', '$N向$n喝道：竟敢偷盗本教的罗刹牌！拿来！', $this, $me);
            $this->kill_ob($me);
            $me->kill_ob($this);
            $this->set_leader($me);
            return true;
        }
    }

    public function accept_object($me, $obj)
    {
        if ($obj->query('name') == '罗刹牌') {
            msg::message('vision', '$N对$n哼了声：咱们的前嫌旧怨，一＂璧＂钩消！', $this, $me);
            $me->del_mark('冷若霜');
            $me->remove_all_killer();
            return true;
        }
        return false;
    }
}
