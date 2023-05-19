<?php
/**
*   上官金虹
*
*/
namespace d\fy\npc;

use std\msg;
use std\master;
use \Workerman\Lib\Timer;

class shangguan extends master
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '上官金虹');
        $this->set('id', 'master-shangguan');
        $this->set("nickname", "HIR龙凤双环NOR");
        $this->set('gender', '男性' );
        $this->set('age', 44);
        $this->set('long','一个人正站在桌子前翻阅着，不时用朱笔在卷宗上勾划，批改，嘴里偶而会露出一丝得意的笑容。他是站着的。他认为一个人只要坐下来，就会令自己的精神松弛，一个人的精神若松弛，就容易造成错误。');
        $this->set("str", 30);
        $this->set("cor", 30);
        $this->set("cps", 30);
        $this->set("int", 30);
	    $this->set("per", 30);
        $this->set("agi",25);
	    $this->set("attitude","friendly");
        $this->set("max_force", 15000);
        $this->set("force", 15000);
        $this->set("force_factor", 3);
        $this->set("chat_chance_combat", 90);
        $this->set('chat_msg_combat' , array('perform dodge.canglongyixian', 'cast freeze'));
        $this->set("combat_exp", 10000000);
        $this->set_skill("move", 70);
        $this->set_skill("parry", 80);
        $this->set_skill("dodge", 80);
        $this->set_skill("force", 80);
        $this->set_skill("literate", 60);
	    $this->set_skill("jingxing",120);
	    $this->set_skill("hammer", 150);
	    $this->set_skill("jinhongsteps", 120);
	    $this->set_skill("longfenghuan", 150);
        $this->map_skill("dodge", "jinhongsteps");
	    $this->map_skill("hammer", "longfenghuan");
	    $this->map_skill("parry", "longfenghuan");
	    $this->map_skill("force", "jingxing");
	    $this->set_skill("spells", 100);
	    $this->set_skill("mapo", 100);
	    $this->map_skill("spells", "mapo");
        $this->set('family', array('family_name' => '金钱帮',
                'generation' => 1,
                'identity' => '帮主',
                'family_master' => null));
        $this->equip_object('/d/fy/npc/obj/whitecloth2');
        $this->equip_object('/d/fy/npc/obj/longfenghuan');
    }

    public function attempt_apprentice($me)
    {
        if ($me->query('str') + $me->query('max_force') / 10 < 60) {
            msg::message('vision', '$N对$n说道：你双臂无力，如何学我的龙凤双环？', $this, $me);
            return false;
        }
        global $DEFAULT_CONN;
        $DEFAULT_CONN->init($this);
        $this->do_cmd($DEFAULT_CONN, 'recruit ' . $me->id);
    }

    public function recruit_apprentice($me)
    {
        parent::recruit_apprentice($me);
        $me->set('class', 'assassin');
    }  

    public function re_rank($student)
    {
        $exp = $student->query('combat_exp');
        if ($exp <= 32000) {
            $student->set("title", "金钱帮帮众");
            return true;
        } elseif ($exp <= 64000) {
            $student->set("title", "金钱帮副堂主");
            return true;
        } elseif ($exp <= 128000) {
            $student->set("title", "金钱帮堂主");
            return true;
        } elseif ($exp <= 256000) {
            $student->set("title", "金钱帮副坛主");
            return true;
        } elseif ($exp <= 512000) {
            $student->set("title", "金钱帮坛主");
            return true;
        } elseif ($exp <= 1024000) {
            $student->set("title", "金钱帮副舵主");
            return true;
        } elseif ($exp <= 1536000) {
            $student->set("title", "金钱帮舵主");
            return true;
        } elseif ($exp <= 2304000) {
            $student->set("title", "金钱帮护法");
            return true;
        } elseif ($exp <= 3456000) {
            $student->set("title", "金钱帮大护法");
            return true;
        } elseif ($exp <= 5187000) {
            $student->set("title", "金钱帮长老");
            return true;
        } elseif ($exp <= 26244000) {
            $student->set("title", "金钱帮大长老");
            return true;
        } else
            $student->set("title", "金钱帮副帮主");
            return true;
    }
}
