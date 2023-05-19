<?php
/**
*   殷正廉
*
*/
namespace d\fy\npc;

use std\msg;
use std\master;
use \Workerman\Lib\Timer;

class governor extends master
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '殷正廉');
        $this->set('id', 'master-yin');
        $this->set("nickname", "HIR一品钦差NOR");
        $this->set('gender', '男性' );
        $this->set('age', 34);
        $this->set('long','风云城中最高的官，有至高无上的权力。');
        $this->set("attitude", "heroism");
	    $this->set("student_title", "官员");

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
	    $this->set("max_kee", 999999);
        $this->set("max_gin", 999999);
        $this->set("max_sen", 999999);
	    $this->set("eff_kee", 999999);
	    $this->set("kee", 999999);
        $this->set("chat_chance_combat", 50);
        $this->set('chat_msg_combat' , array('perform yuhuan'));
        $this->set("combat_exp", 90000000);
        $this->set_temp("apply/damage",500);
        $this->set_skill("unarmed", 200);
	    $this->set_skill("sword", 100);
	    $this->set_skill("force", 80);
        $this->set_skill("parry", 120);
        $this->set_skill("dodge", 110);
	    $this->set_skill("changquan", 200);
	    $this->set_skill("feixiansteps", 60);
	    $this->set_skill("feixiansword", 80);
	    $this->set_skill("jingyiforce", 50);
        $this->set_skill("move", 100);
	    $this->set_skill("literate", 90);
	    $this->set_skill("leadership", 200);
	    $this->set_skill("strategy", 200);
	    $this->map_skill("unarmed", "changquan");
	    $this->map_skill("dodge", "feixiansteps");
	    $this->map_skill("force", "jingyiforce");
	    $this->map_skill("sword", "feixiansword");
        $this->set('family', array('family_name' => '朝廷',
                'generation' => 6,
                'identity' => '官员',
                'family_master' => null));
        $this->equip_object('/d/fy/npc/obj/guanfu');
    }

    public function attempt_apprentice($me)
    {
        global $DEFAULT_CONN;
        $DEFAULT_CONN->init($this);
        if ($me->query('class') == null) {    
            $this->do_cmd($DEFAULT_CONN, 'smile');
            $this->do_cmd($DEFAULT_CONN, 'say 很好！朝廷正在用人之时，努力吧！');
            $this->do_cmd($DEFAULT_CONN, 'recruit ' . $me->id);
            return true;
        } else {
            $this->do_cmd($DEFAULT_CONN, 'say 朝廷不需要你这种不三不四，来历不明之人！');
            return false;
        }
    }

    public function recruit_apprentice($me)
    {
        parent::recruit_apprentice($me);
        $me->set('class', 'official');
        $me->set("vendetta_mark", "authority");
    }  

    public function re_rank($student)
    {
        $exp = $student->query('combat_exp');
        if ($exp <= 32000) {
            $student->set("title","朝廷七品芝麻官");
            return true;
        } elseif ($exp <= 64000) {
            $student->set("title","朝廷六品官");
            return true;
        } elseif ($exp <= 128000) {
            $student->set("title","朝廷五品官");
            return true;
        } elseif ($exp <= 256000) {
            $student->set("title","朝廷四品官");
            return true;
        } elseif ($exp <= 512000) {
            $student->set("title","朝廷三品官");
            return true;
        } elseif ($exp <= 1024000) {
            $student->set("title","朝廷二品官");
            return true;
        } elseif ($exp <= 1536000) {
            $student->set("title","朝廷一品官");
            return true;
        } elseif ($exp <= 2304000) {
            $student->set("title","朝廷钦差大臣");
            return true;
        } elseif ($exp <= 3456000) {
            $student->set("title","朝廷兵马统领");
            return true;
        } elseif ($exp <= 5187000) {
            $student->set("title","朝廷兵马总统领");
            return true;
        } elseif ($exp <= 26244000) {
            $student->set("title","镇远将军");
            return true;
        } else
            $student->set("title","定国大将军");
            return true;
    }
}
