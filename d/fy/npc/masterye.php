<?php
/**
*   叶孤城
*
*/
namespace d\fy\npc;

use std\msg;
use std\master;
use \Workerman\Lib\Timer;

class masterye extends master
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '叶孤城');
        $this->set('id', 'master-ye');
        $this->set("nickname", "HIW白云城主NOR");
        $this->set('gender', '男性' );
        $this->set('age', 34);
        $this->set('long','白云城主以前充满了尊荣和光采．而现在．．．他知道那被唐门暗器所伤的伤口已完全溃烂．．．');
        $this->set("str", 30);
        $this->set("cor", 30);
        $this->set("cps", 30);
        $this->set("int", 30);
	    $this->set("per", 30);
        $this->set("agi",25);
	    $this->set("attitude","friendly");
        $this->set("max_force", 15000);
        $this->set("force", 15000);
        $this->set("force_factor", 30);
	    $this->set("max_kee",99999999);
        $this->set("max_gin",999999);
        $this->set("max_sen",999999);
	    $this->set("eff_kee",999999);
	    $this->set("kee",999999);
        $this->set("chat_chance", 1);
        $this->set("chat_chance_combat", 90);
        $this->set("chat_msg", array("叶孤城从点点血斑的白袍撕下一条布条。<br>叶孤城用从点点血斑的白袍撕下的布条替自己裹伤。"));
        $this->set('chat_msg_combat' , array('perform dodge.tianwaifeixian', 'perform sword.tianwaifeixian'));
        $this->set("combat_exp", 100000000);
        $this->set_skill("move", 100);
	    $this->set_skill("daode",150);
        $this->set_skill("parry", 120);
        $this->set_skill("dodge", 80);
        $this->set_skill("force", 40);
        $this->set_skill("literate", 60);
	    $this->set_skill("sword", 100);
	    $this->set_skill("unarmed",40);
	    $this->set_skill("changquan",100);
	    $this->set_skill("feixiansteps",100);
	    $this->set_skill("feixiansword",150);
	    $this->set_skill("jingyiforce", 60);
        $this->map_skill('force', 'jingyiforce');
        $this->map_skill('unarmed', 'changquan');
        $this->map_skill('move', 'feixiansteps');
        $this->map_skill('dodge', 'feixiansteps');
        $this->map_skill('sword', 'feixiansword');
        $this->set('family', array('family_name' => '白云城',
                'generation' => 2,
                'identity' => '城主',
                'family_master' => null));
        $this->equip_object('/d/fy/npc/obj/bsword');
        $this->equip_object('/d/fy/npc/obj/bcloth');
        $this->equip_object('/d/fy/npc/obj/whitecloth');
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
        $me->set('class', 'swordsman');
    }  

    public function accept_object($me, $obj)
    {
        if ($obj->query("name") == "七彩丝缎带" && $obj->query("realsilk") != null)
        {
            msg::message_text('say', '我身受重伤，还是你画妆成我去吧！<br>但你武功低微．．．．<br>兴国禅寺的主持是我的好友，也许他可帮上你．', $me);
        	$me->set_temp("marks/ye", 1);
	        return true;
        }
        return false;
    }

    public function re_rank($student)
    {
        $exp = $student->query('combat_exp');
        if ($exp <= 32000) {
            $student->set("title","白云城弟子");
            return true;
        } elseif ($exp <= 128000) {
            $student->set("title","白云城领班");
            return true;
        } elseif ($exp <= 512000) {
            $student->set("title","白云城小管家");
            return true;
        } elseif ($exp <= 1536000) {
            $student->set("title","白云城管家");
            return true;
        } elseif ($exp <= 3456000) {
            $student->set("title","白云城大管家");
            return true;
        } elseif ($exp <= 5187000) {
            $student->set("title","白云城总管");
            return true;
        } elseif ($exp <= 26244000) {
            $student->set("title","白云城大总管");
            return true;
        } else
            $student->set("title","白云城副城主");
            return true;
    }
}
