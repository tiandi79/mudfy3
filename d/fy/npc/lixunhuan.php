<?php
/**
*   李寻欢
*
*/
namespace d\fy\npc;

use std\msg;
use std\master;
use std\attack;
use \Workerman\Lib\Timer;

class lixunhuan extends master
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '李寻欢');
        $this->set('id', 'lixunhuan');
        $this->set("nickname", "HIR小李飞刀NOR");
        $this->set('gender', '男性' );
        $this->set('age', 44);
        $this->set('long','李寻欢别号李探花，又有江湖绰号小李飞刀。一手飞刀绝技，在百晓生的兵器谱上排行第三。不发则已，但例无虚发。');
        $this->set("str", 30);
        $this->set("cor", 30);
        $this->set("cps", 30);
        $this->set("int", 30);
	    $this->set("per", 30);
	    $this->set("attitude","friendly");
        $this->set("max_force", 15000);
        $this->set("force", 15000);
	    $this->set("courage",1000);
        $this->set("force_factor", 3);
        $this->set("rank_info/respect", "李探花");
        $this->set("combat_exp", 10000000);
        $this->set("score", 200000);
        $this->set_skill("move", 200);
        $this->set_skill("parry", 200);
        $this->set_skill("dodge", 200);
        $this->set_skill("throwing", 300);
	    $this->set_skill("feidao", 220);
        $this->set_skill("force", 40);
        $this->set_skill("literate", 200);
       	$this->map_skill("throwing", "feidao");

        $this->set("chat_chance", 10);

        $this->set("chat_msg", array("李寻欢不停的在咳，嘴角流下一丝鲜血。",
            '李寻欢的脸色越发苍白了。',
            '李寻欢叹口气，呆呆地望着手里的木像。'));

        $this->set('family', array('family_name' => '风云一刀',
                'generation' => 2,
                'identity' => '人杰',
                'family_master' => null));
        $this->set("student_title", "人杰");

        $this->equip_object('/d/fy/npc/obj/whitecloth2');
    }

    public function attempt_apprentice($me)
    {
        if ((time() - $me->query("last_time_app_master_li")) < 3600) {
	        msg::message('vision', '$N笑道：你怎么这么快又回来了．．．', $this, $me);
            return false;
        }

        if ($me->query("force_factor") < 100) {
	        msg::message('vision', '$N笑道：你对武功的了解还不够．．．', $this, $me);
            return false;
        }

        if (rand(0, 500) || rand($me->query("kar")) < 25 || $this->query("already") != null)
	    {
	        msg::message('vision', '$N咳了两声，说道：不要开玩笑，我可不想误人子弟。', $this, $me);
	    	$me->set("last_time_app_master_li", time());
            return false;
        }

        global $DEFAULT_CONN, $RANK_D;
        $DEFAULT_CONN->init($this);
        $this->do_cmd($DEFAULT_CONN, 'say 很好，' . $RANK_D->query_respect($me) . '他日切不可为非作歹。');
        $this->do_cmd($DEFAULT_CONN, 'recruit ' . $me->id);
        $me->del('betrayer');
    }

    public function recruit_apprentice($me)
    {
        parent::recruit_apprentice($me);
        $me->set('class', 'traveller');
        $this->set('already', 1);
    }  

    public function heart_beat()
    {
        if ($this->query_temp("weapon") == null && $this->is_fighting())
        {
            global $OBJECT, $DEFAULT_CONN, $GAMESKILLS;
            $feidao = $OBJECT->create_objects('d/fy/npc/obj/xlfd');
            $feidao->move($this);
            $DEFAULT_CONN->init($this);
            $this->do_cmd($DEFAULT_CONN, 'wield flying-blade');
            $pfm_skill = $GAMESKILLS->get_pfm($GAMESKILLS->get('feidao'), 'xiaolifeidao', '');
            $target = attack::select_opponent($this);
            $pfm_skill->kill_him($this, $target);
	        return true;
        }
        else
            parent::heart_beat();
    }
}
