<?php
/**
*   waiter
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;
use \Workerman\Lib\Timer;

class waiter extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '店小二');
        $this->set('id', 'waiter');
        $this->set('age', 36);
        $this->set('gender', '男性');
        $this->set('long', '这位店小二正笑咪咪地忙著，还不时拿起挂在脖子上的抹布擦脸。');
        $this->set("vendor_goods", array("/obj/obj/wineskin" => 10,
		    "/obj/obj/dumpling" => 30,
		    "/obj/obj/chickenleg" => 40));
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
                    msg::message_text('vision', '店小二笑咪咪地说道：这位' . $RANK_D->query_respect($me) . '，进来喝杯茶，歇歇腿吧。', $this);
                    break;
                case 1:
                    msg::message_text('vision', '店小二用脖子上的毛巾抹了抹手，说道：这位' . $RANK_D->query_respect($me) . '，请进请进。', $this);
                    break;
                default:
                    msg::message_text('vision', '店小二说道：这位' . $RANK_D->query_respect($me) . '，进来喝几盅小店的红酒吧，这几天才从窖子里开封的哟。', $this);
            }
            
        }
    }
}
