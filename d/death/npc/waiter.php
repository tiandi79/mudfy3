<?php
/**
*   waiter
*
*/
namespace d\death\npc;

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
        $this->set('name', '马老四');
        $this->set('id', 'max');
        $this->set('age', 62);
        $this->set('gender', '男性');
        $this->set('combat_exp', 500);
        $this->set('long', '这位店家满脸黑气，印堂发黑，一身白衣服，就象刚刚出殡回来一样。');
        $this->set("attitude", "friendly");
	    $this->set_temp("apply/astral_vision",1);
	    $this->set("rank_info/respect", "老店家");
        $this->set("vendor_goods", array("/d/death/npc/obj/pumpkin" => 10,
		    "/d/death/npc/obj/wineskin" => 20));
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
                    msg::message_text('vision', '马老四道：这位' . $RANK_D->query_respect($me) . '，投胎．．，哦哦．．不，不，投宿吗？', $this);
                    break;
                case 1:
                    msg::message_text('vision', '马老四道：' . $RANK_D->query_respect($me) . '，请进请进,早投宿，早起来。', $this);
                    break;
                default:
                    msg::message_text('vision', '马老四咳道：这位' . $RANK_D->query_respect($me) . '，进来喝几盅小店的还阳酒吧！', $this);
            }
            
        }
    }
}
