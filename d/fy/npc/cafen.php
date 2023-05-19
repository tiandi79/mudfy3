<?php
/**
*   胡英
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;

class cafen extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '胡英');
        $this->set('id', 'huying');
        $this->set('age', 55);
        $this->set('title', '棺材店老板');
        $this->set('gender', '男性');
        $this->set('long', '这位老人的脸上布满绉纹．．．');
        $this->set("combat_exp", 10);
        $this->set("str", 27);
        $this->set("cor", 26);
        $this->set("cps", 25);
	    $this->set("attitude", "friendly");
        $this->set("vendor_goods", array('d/fy/npc/obj/zhiqian' => 10,
           '/obj/obj/paperseal' => 20));
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
            $i = rand(0, 10);
            switch($i) {
                case 0:
                    msg::message('vision', '$N看了$n一眼道：木棺没货，都订了，酞多人死了。', $this, $me);
                    break;
                case 1:
                    msg::message('vision', '$N向$n问道：谁死了？', $this, $me);
                    break;
            }
            
        }
    }
}
