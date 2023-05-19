<?php
/**
*   小童
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;

class showerboy extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '小童');
        $this->set('id', 'xiaotong');
        $this->set('age', 14);
        $this->set('gender', '男性');
        $this->set('long', '一个天真无邪的小童。');
        $this->set('combat_exp', 500000);
        $this->set("attitude", "friendly");
        $this->set("per",30);
        $this->set_skill("unarmed", 5);
	    $this->set_skill("dodge", 5);
        $this->equip_object('/d/fy/npc/obj/yellowcloth');
        $this->set("vendor_goods", array("/d/fy/npc/obj/whitetowel" => 10));
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
                    msg::message('vision', '$N在百忙中抬起头望了$n一眼。', $this, $me);
                    break;
                default:
            }            
        }
    }
}
