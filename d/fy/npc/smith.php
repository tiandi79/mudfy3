<?php
/**
*   张铁匠
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;
use \Workerman\Lib\Timer;

class smith extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '张铁匠');
        $this->set('id', 'zhang');
        $this->set('age', 52);
        $this->set('gender', '男性');
        $this->set('long', '张铁匠一身打铁功夫名不虚传，他打出的铁器经久耐用。');
        $this->set('combat_exp', 5);
        $this->set("attitude", "friendly");
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
            $i = rand(0,5);
            switch($i) {
                case 0:
                    msg::message_text('vision', '张铁匠粗声粗气地说道：这位' . $RANK_D->query_respect($me) . '，要什么？', $this);
                    break;
                case 1:
                    msg::message_text('vision', '张铁匠满脸汗水说道：这位' . $RANK_D->query_respect($me) . '，我太忙了，帮不了你。', $this);
                    break;
                default:
            }
            
        }
    }

    public function do_ding($ob, $arg)
    {
        $ob->ssend(OPENSOON);
        return true;
    }   
}
