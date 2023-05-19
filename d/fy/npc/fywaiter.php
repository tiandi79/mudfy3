<?php
/**
*   苏红儿
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;
use \Workerman\Lib\Timer;

class fywaiter extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '苏红儿');
        $this->set('id', 'suhong');
        $this->set('age', 21);
        $this->set('gender', '女性');
        $this->set('title', '老板娘');
        $this->set('long', '这位老板娘正斜依在柜台边，笑咪咪地望着你。');
        $this->set('combat_exp', 500000);
        $this->set("attitude", "friendly");
	    $this->set("per",30);
        
        $this->set_skill("unarmed", 50);
	    $this->set_skill("tenderzhi", 50);
	    $this->set_skill("dodge", 50);
	    $this->set_skill("stormdance", 50);
	    $this->map_skill("dodge", "stormdance");	
	    $this->map_skill("unarmed", "tenderzhi");

        $this->set("vendor_goods", array("/d/fy/npc/obj/yxrs" => 10,
		    "/d/fy/npc/obj/cddt" => 10,
		    "/d/fy/npc/obj/frsp" => 10,
            "/d/fy/npc/obj/ssqy" => 10,
            "/d/fy/npc/obj/ylzp" => 10,
            "/d/fy/npc/obj/pwym" => 10,
            "/d/fy/npc/obj/cwgp" => 10,
            "/d/fy/npc/obj/ychz" => 10,
            "/d/fy/npc/obj/jxyz" => 10,
            "/d/fy/npc/obj/zypg" => 10,
            "/d/fy/npc/obj/rxcy" => 10,
            "/d/fy/npc/obj/qcsh" => 10,
            "/d/fy/npc/obj/hyjp" => 10,
            "/d/fy/npc/obj/szpc" => 10,
            "/d/fy/npc/obj/glyc" => 10,
            "/d/fy/npc/obj/xcfs" => 10,
            "/d/fy/npc/obj/cpcy" => 10,
            "/d/fy/npc/obj/gzyq" => 10,
            "/d/fy/npc/obj/qcxr" => 10,
            "/d/fy/npc/obj/jymj" => 10,
            "/d/fy/npc/obj/glxj" => 10,
            "/d/fy/npc/obj/cpdx" => 10,
            "/d/fy/npc/obj/pxhy" => 10));
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
            $i = rand(0,2);
            switch($i) {
                case 0:
                    msg::message('vision', '$N眼角含笑，有意无意的瞟了$n一眼。', $this, $me);
                    break;
                case 1:
                    msg::message('vision', '$N纤腰微摆，露出羊脂般的玉臂，向$n招了招手。', $this, $me);
                    break;
                default:
                    msg::message('vision', '$N望了$n一眼，用玉手掩着樱桃小嘴轻笑起来。', $this, $me);
            }
            
        }
    }
}
