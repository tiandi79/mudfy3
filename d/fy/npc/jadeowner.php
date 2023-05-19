<?php
/**
*   waiter
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;
use \Workerman\Lib\Timer;

class jadeowner extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '商玉龙');
        $this->set('id', 'jadeowner');
        $this->set('age', 49);
        $this->set('gender', '男性');
        $this->set('long', '这是一位肥肥胖胖店掌柜。');
        $this->set("combat_exp", 700000);
	    $this->set("str", 300);
        $this->set("attitude", "friendly");
        $this->set_skill("dodge", 100);
        $this->set_skill("parry", 120);
        $this->equip_object('/obj/obj/cloth');
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
            $i = rand(0,1);
            switch($i) {
                case 0:
                    msg::message_text('vision', '店掌柜笑着道：这位' . $RANK_D->query_respect($me) . '，买玉吗？', $this);
                    break;
                default:
                    msg::message_text('vision', '店掌柜笑着道：这位' . $RANK_D->query_respect($me) . '，玉是吉祥之物，买一块吧。', $this);
            }
            
        }
    }
}
