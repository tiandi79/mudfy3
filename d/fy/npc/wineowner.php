<?php
/**
*   驼背老汉
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;

class wineowner extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '驼背老汉');
        $this->set('id', 'han');
        $this->set('age', 55);
        $this->set('gender', '男性');
        $this->set('long', '这位老汉好象快不行了．．．');
        $this->set("combat_exp", 50);
	    $this->set("attitude", "friendly");
        $this->set("vendor_goods", array('d/fy/npc/obj/nujiu' => 10,
            'd/fy/npc/obj/xiaocai' => 10));
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
            $i = rand(0, 10);
            switch($i) {
                case 0:
                    msg::message('vision', '$N沉重的喘吸着，勉强抬起头看$n一眼。', $this, $me);
                    break;
                case 1:
                    msg::message('vision', '$N直了直腰，勉强向$n招了招手。', $this, $me);
                    break;
            }     
        }
    }
}
