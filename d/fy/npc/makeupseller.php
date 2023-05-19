<?php
/**
*   芳儿
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;

class makeupseller extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '芳儿');
        $this->set('id', 'fang');
        $this->set('age', 29);
        $this->set('gender', '女性');
        $this->set("title", "HIY千NORHIR面NORHIM娘NORHIC子NOR");
        $this->set('long', '这位年轻风骚的老板正对你狂抛媚眼儿。');
        $this->set('combat_exp', 50000);
        $this->set("attitude", "friendly");
        $this->set("per",30);
        $this->set_skill("unarmed",200);
	    $this->set_skill("dodge",200);
        $this->equip_object('/d/fy/npc/obj/wchskirt');
        $this->set("vendor_goods", array("/d/fy/npc/obj/yanzhi" => 10,
		    "/d/fy/npc/obj/bao" => 10,
		    "/d/fy/npc/obj/huabag" => 10));
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
            $i = rand(0, 1);
            switch($i) {
                case 0:
                    msg::message('vision', '$N笑着说道：这儿什么都有，买些回去给你的心上人吧。', $this);
                    break;
                case 1:
                    msg::message('vision', '$N用一种奇异的眼神望着$n。', $this, $me);
                    break;
                default:
            }            
        }
    }

    public function accept_object($me, $ob)
    {
        msg::message('vision', '$N对着$n表情僵硬的笑了笑．．．', $this, $me);
        if (!$gender = $ob->query('targetgender'))
            return false;
        if (!$id = $ob->query('targetid'))
            return false;
        if (!$name = $ob->query('targetname'))
            return false;
        if ($gender != '男性' && $gender != '女性')
            return false;
        
        global $OBJECT;
        $mask = $OBJECT->create_objects('/d/fy/npc/obj/mask');
        $mask->set('fakename', $name);
        $mask->set('fakeid', $id);
        $mask->set('fakegender', $gender);
        $mask->set('long', '一张' . $name . '的人皮面具。');
        $mask->move($me);        
        msg::message('vision', '$N悄悄的塞给$n一样东西。', $this, $me);
        return true;
    }
}
