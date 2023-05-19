<?php
/**
*   查猛
*
*/
namespace d\fy\npc;

use std\msg;
use std\master;
use \Workerman\Lib\Timer;

class gmaster extends master
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '查猛');
        $this->set('id', 'meng');
        $this->set("nickname", "HIY金狮掌NOR");
        $this->set('gender', '男性' );
        $this->set('age', 42);
        $this->set('long','金狮掌查猛是少林俗家弟子，人不但性情豪爽，且广交朋友．凡是想向他求教的，只要为镖局出点力，他就肯教。');
        $this->set("skill_public", 1);
        $this->set("inquiry", array("mission" => '暂未开放', "护镖" => '暂未开放'));
        $this->set("attitude", "peaceful");
	    $this->set_skill("unarmed", 30);
	    $this->set_skill("changquan", 30);
	    $this->set_skill("literate", 30);
	    $this->set_skill("force", 30);
	    $this->set_skill("dodge",30);
	    $this->set_skill("parry",30);
	    $this->map_skill("unarmed", "changquan");
	    $this->set("combat_exp", 90000);
        $this->set('family', array('family_name' => '少林俗家',
                'generation' => 21,
                'identity' => '弟子',
                'family_master' => null));
        $this->equip_object('/d/fy/npc/obj/jinzhuang');
    }

    public function recognize_apprentice($me)
    {
        if ((time() - $ob->get_mark('金狮')) > 1800) {
            msg::message('say', "你．．你好象很久没为镖局出过力了....", $this);
            return false;
        }
        return true;
    }
}
