<?php
/**
*   香菱
*
*/
namespace d\fy\npc;

use std\msg;
use std\pawnowner;

class hockowner extends pawnowner
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '香菱');
        $this->set('id', 'xiangling');
        $this->set('age', 29);
        $this->set('gender', '女性');
        $this->set("title", "当铺老板娘");
        $this->set('long', '香菱从小被卖到千金楼，生活凄苦，但因善长得男人欢心，终被一富豪看中，娶为第十八房小老婆。');        
        $this->set("combat_exp", 5000);
	    $this->set("attitude", "friendly");
	    $this->set("per", 30);
	    $this->set("no_arrest", 1);
	    $this->set_skill("unarmed",200);
        $this->set("richness", 50000);
	    $this->set_skill("dodge", 200);
        $this->equip_object('d/fy/npc/obj/huaskirt');
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
            if ($me->query('gender') == '男性') {
                $i = rand(0,5);
                switch($i) {
                    case 0:
                        msg::message('vision', '$N嗲声嗲气地说道：哎呦呦呦呦．．．这位' . $RANK_D->query_respect($me) . '，是啥风儿把您吹到这儿来了？', $this);
                        break;
                    case 1:
                        msg::message('vision', '$N上前拉住$n的手，笑咪咪地说道：这位' . $RANK_D->query_respect($me) . '，您好象比上次来这儿时更高大威猛，英俊潇洒了！', $this, $me);
                        break;
                }
            } else {
                $i = rand(0,5);
                switch($i) {
                    case 0:
                        msg::message('vision', '$N上前轻抚$n的粉脸，说道：这位' . $RANK_D->query_respect($me) . '，您可真标致！嫉妒死我了！', $this, $me);
                        break;
                }
            }            
        }
    }
}
