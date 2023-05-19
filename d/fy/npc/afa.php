<?php
/**
*   阿发
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;

class afa extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '阿发');
        $this->set('id', 'afa');
        $this->set('age', 22);
        $this->set('gender', '女性');
        $this->set('long', '这里很暗，你看不清阿发的样子。');
        $this->set("combat_exp", 10);
        $this->set("str", 27);
        $this->set("cor", 26);
        $this->set("cps", 25);
	    $this->set("attitude", "friendly");
        $this->set("vendor_goods", array('d/fy/npc/obj/bblade' => 20));
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
                    msg::message_text('vision', '$N对$n说：你地知唔知天下最犀利，功夫真是莫得顶，作木器最劲的还宾个？', $this, $me);
                    break;
            }
            
        }
    }
}
