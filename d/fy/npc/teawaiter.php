<?php
/**
*   waiter
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;
use \Workerman\Lib\Timer;

class teawaiter extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '茶博士');
        $this->set('id', 'waiter');
        $this->set('age', 40);
        $this->set('gender', '男性');
        $this->set('long', '茶博士正忙着招呼客人, 一手提着茶壶, 一手拿着抹布。');
        $this->set("combat_exp", 5);
        $this->set("attitude", "friendly");
        $this->set("rank_info/respect", "茶博士");
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
                    msg::message_text('vision', '茶博士笑咪咪地说道：这位' . $RANK_D->query_respect($me) . '，进来喝杯茶，歇歇腿吧。', $this);
                    break;
                case 1:
                    msg::message_text('vision', '茶博士用毛巾抹了抹靠门的一张桌子，说道：这位' . $RANK_D->query_respect($me) . '，请进请进。', $this);
                    break;
                default:
                    msg::message_text('vision', '茶博士说道：这位' . $RANK_D->query_respect($me) . '，进来尝尝才采的新茶叶。哇! 好香啊!...', $this);
            }
            
        }
    }
}
