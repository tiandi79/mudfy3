<?php
/**
*   waiter
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;
use \Workerman\Lib\Timer;

class servent extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '铁传甲');
        $this->set('id', 'servent');
        $this->set('age', 42);
        $this->set('gender', '男性');
        $this->set('long', '他是小李飞刀的贴心佣人，向来和李探花形影不离。');
        $this->set("combat_exp", 500000);
	    $this->set("per", 10);
	    $this->set("attitude", "friendly");
        $this->set_skill("ironcloth", 200);
	    //$this->set_skill("jin-gang",100);
	    $this->set_skill("unarmed", 100);
	    $this->set_skill("bloodystrike", 100);
	    $this->map_skill("unarmed", "bloodystrike");
	    //$this->map_skill("iron-cloth", "jin-gang");
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
            $i = rand(0,10);
            switch($i) {
                case 0:
                    msg::message('vision', '$N一仰头，灌下一口烈酒。', $this);
                    break;
                case 1:
                    msg::message('vision', '$N用忧伤的眼神扫了$n一眼，似乎心里有化不开的愁。', $this, $me);
                    break;
                default:
                    msg::message('vision', '$N用警惕的眼神上下打量着$n，无意中扫了一眼墙上的红布挂帘。', $this, $me);
            }
            
        }
    }
}
