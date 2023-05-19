<?php
/**
*   黄麻子
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;

class huang extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '黄麻子');
        $this->set('id', 'huang');
        $this->set('age', 32);
        $this->set('gender', '男性');
        $this->set('title', 'HIW银钩手NOR');
        $this->set('long', '这是银钩赌坊的职业赌手，骰子上的功夫出神入化。');
        $this->set("combat_exp", 100000);
        $this->set("str", 27);
        $this->set("cor", 26);
        $this->set("cps", 25);
	    $this->set("attitude", "friendly");
        $this->set("max_force", 50000000);
	    $this->set("force_factor", 250);
        $this->set("max_gin", 3000);
        $this->set("max_kee", 3000);
        $this->set("max_sen", 3000);
        $this->set("eff_gin", 3000);
        $this->set("eff_kee", 3000);
        $this->set("eff_sen", 3000);
        $this->set("gin", 3000);
        $this->set("kee", 99999);
        $this->set("sen", 3000);
        $this->set("max_atman", 300);
        $this->set("atman", 300);
        $this->set("max_force", 3000);
        $this->set("force", 3000);
        $this->set("max_mana", 300);
        $this->set("mana", 300);
	    $this->set_skill("unarmed", 200 + rand(0, 100));
	    $this->set_skill("parry", 200 + rand(0, 100));
        $this->set_skill("dodge", 200 + rand(0, 100));
        $this->set_skill("move", 200 + rand(0, 100));
        $this->set_temp("apply/damage", 600);
        $this->equip_object('/d/fy/npc/obj/yingoupao');
        $this->equip_object('/d/fy/npc/obj/guzi');
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
            $i = rand(0,2);
            switch($i) {
                case 0:
                    msg::message_text('vision', '黄麻子笑咪咪地说道：这位' . $RANK_D->query_respect($me) . '，过来赌两手，开开心吧。', $this);
                    break;
                case 1:
                    msg::message_text('vision', '黄麻子晃了晃手中的骰子，叫道：这位' . $RANK_D->query_respect($me) . '，小赌可以养家糊口，大赌可以定国安邦。来吧！', $this);
                    break;
                default:
                    msg::message_text('vision', '黄麻子说道：这位' . $RANK_D->query_respect($me) . '，进来！进来！ 输了算我的！', $this);
            }
            
        }
    }

    public function do_bet($ob, $arg)
    {
        $ob->ssend(OPENSOON);
        return true;
    }
}
