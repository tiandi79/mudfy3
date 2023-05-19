<?php
/**
*   龙小云
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;
use \Workerman\Lib\Timer;

class lson extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '龙小云');
        $this->set('id', 'xiaoyun');
        $this->set('age', 14);
        $this->set('title', '红孩儿');
        $this->set('gender', '男性');
        $this->set('long', '一个天真无邪，未懂世事的小还子．．至少表面如此．．．');
        $this->set("combat_exp", 5);
	    $this->set("attitude", "aggrensive");
	    $this->set("per",30);
	    $this->set_skill("unarmed",5);
	    $this->set_skill("dodge",5);
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
            $i = rand(0,9);
            switch($i) {
                case 0:
                    msg::message_text('vision', '龙小云低声道：找到小李飞刀，上官金虹一定会答应收我为徒的．', $this);
                    break;
                default:
            }            
        }
    }
}
