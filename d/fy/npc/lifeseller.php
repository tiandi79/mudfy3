<?php
/**
*   薛陀子
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;

class lifeseller extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '薛陀子');
        $this->set('id', 'xue');
        $this->set('age', 69);
        $this->set('gender', '男性');
        $this->set('long', '这位陀子正用白多黑少的双眼盯着你。');
        $this->set('combat_exp', 500000);
        $this->set("attitude", "friendly");
        $this->set("per", 30);
        $this->set_skill("unarmd", 200);
	    $this->set_skill("dodge", 200);
        $this->set("vendor_goods", array("/d/fy/npc/obj/baozi1" => 10,
		    "/d/fy/npc/obj/baozi2" => 10,
		    "/d/fy/npc/obj/baozi3" => 10,
            "/d/fy/npc/obj/baozi4" => 10,
            "/d/fy/npc/obj/baozi5" => 10));
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
                    msg::message('vision', '$N用白多黑少的眼睛盯了$n一眼。', $this, $me);
                    break;
                case 1:
                    msg::message_text('vision', '$N捶了捶自己的陀背说道：这位' . $RANK_D->query_respect($me) . '要买什么？',$this, $me);
                    break;
                default:
            }            
        }
    }

    public function accept_object($me, $obj)
    {
        if ($obj->query('value') > 2000) {
            global $OBJECT, $RANK_D;
            $paper = $OBJECT->create_objects('d/fy/npc/obj/baozhizhi');
            $paper->move($me);
            $paper->set('targetprice', $obj->query('value'));
            global $DEFAULT_CONN;
            $DEFAULT_CONN->init($this);
            $this->do_cmd($DEFAULT_CONN, 'say 多谢这位' . $RANK_D->query_respect($me) . '可怜我这没用的穷老人。');
            return true;
        }
        return false;
    }
}
