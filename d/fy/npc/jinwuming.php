<?php
/**
*   荆无命
*
*/
namespace d\fy\npc;

use std\msg;
use std\master;
use \Workerman\Lib\Timer;

class jinwuming extends master
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '荆无命');
        $this->set('id', 'master-jin');
        $this->set("nickname", "HIR左手剑NOR");
        $this->set('gender', '男性' );
        $this->set('age', 44);
        $this->set('long','这人的身子站得更直，更挺，就像是一杆枪。他整个人似已麻木，既不知痛痒，也不知哀乐。');
        $this->set("str", 30);
        $this->set("cor", 30);
        $this->set("cps", 30);
        $this->set("int", 30);
	    $this->set("per", 3);
        $this->set("agi",25);
	    $this->set("attitude","friendly");
        $this->set("max_force", 15000);
        $this->set("force", 15000);
        $this->set("force_factor", 3);
        $this->set("chat_chance_combat", 90);
        $this->set('chat_msg_combat' , array('perform sharenruma'));
        $this->set("combat_exp", 1000000);
        $this->set_skill("move", 50);
        $this->set_skill("parry", 60);
        $this->set_skill("dodge", 60);
        $this->set_skill("force", 60);
        $this->set_skill("literate", 30);
	    $this->set_skill("sword", 90);
	    $this->set_skill("jingxing", 60);
	    $this->set_skill("jinhongsteps", 60);
	    $this->set_skill("lefthandsword",60);
	    $this->set_skill("sharensword", 150);
        $this->map_skill('force', 'jingxing');
        $this->map_skill('dodge', 'jinhongsteps');
        $this->map_skill('sword', 'sharensword');
        $this->set('family', array('family_name' => '金钱帮',
                'generation' => 2,
                'identity' => '护法',
                'family_master' => null));
        $this->equip_object('/d/fy/npc/obj/whitecloth2');
        $this->equip_object('/obj/obj/longsword');
    }

    public function attempt_apprentice($me)
    {
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
