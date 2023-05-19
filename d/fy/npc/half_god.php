<?php
/**
*   天机老人
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;
use \Workerman\Lib\Timer;

class half_god extends char
{
    public $timerid;
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '天机老人');
        $this->set('id', 'tianji');
        $this->set('age', 99);
        $this->set('gender', '男性');
        $this->set('long', '天机老人年过六甲，鹤发童颜。在兵器谱上排名第一，
尤在上官，小李之上．此人亦正亦邪，凡事都由爱恶而定。天机老人收徒极挑剔．．．．');
        $this->set("str", 26000);
	    $this->set("cor", 30);
	    $this->set("int", 24);
	    $this->set("cps", 30);
        $this->set("attitude", "peaceful");
        $this->set("skill_public", 1);
        $this->set("force", 40000);
	    $this->set("max_force", 80000);
	    $this->set("force_factor", 1000);
	    $this->set("combat_exp", 10000000);
	    $this->set("score", 200000);
	    $this->set_skill("unarmed", 120);
	    $this->set_skill("force", 100);
        $this->set_skill("dagger",200);
	    $this->set_temp("apply/attack",300);
	    $this->set_temp("apply/damage",30000);
        $this->set("title", "闲云野鹤");
        $this->set("chat_chance", 1);
        $this->set("chat_msg", array("天机老人拿起旱烟抽了几口．．．．"));
        $this->set('family', array('family_name' => '逍遥派',
                'generation' => 1,
                'identity' => '祖师',
                'family_master' => null));
        $this->equip_object('d/fy/npc/obj/hanyan');
        $this->equip_object('d/fy/npc/obj/jadecloth');
        $this->equip_object('d/fy/npc/obj/jadepin');
        $this->equip_object('d/fy/npc/obj/jadering');
        $this->equip_object('d/fy/npc/obj/jadeboots');
    }

    public function accept_fight($me = null)
    {
        msg::message('say', '生命可贵！不要自寻死路！', $this);
        return false;
    }

    public function attempt_apprentice($me)
    {
        switch(rand(0,3)) {
            case 0:
                msg::message('vision', '$N对$n笑问道：什么是心剑？', $this, $me);
                break;
            case 1:
                msg::message('vision', '$N对$n笑问道：什么是＂敌不动，我不动；敌一动，我先动？', $this, $me);
                break;
            case 2:
                msg::message('vision', '$N对$n笑问道：有形，无形＂是什么？', $this, $me);
                break;
            case 3:
                msg::message('vision', '$N对$n笑问道：武学的最高境界是什么？', $this, $me);
                break;
        }
    }

    public function do_quest($ob, $arg = null)
    {
        $me = $ob->body;
        $levels = array('0', '4000', '8000', '16000', '32000', '64000', '128000', '256000', '512000', '1024000', '1536000', '2304000', '3456000', '5184000', '7776000', '11664000', '17496000', '26244000', '40000000');
        $exp = $me->query('combat_exp');
        if ($exp > MAX_QUEST_EXP) {
            $ob->ssend('天机老人已经不会给你任何任务了！');
            return true;
        }
        if ($me->is_ghost()) {
            $ob->ssend('鬼魂不可要任务。');
            return true;
        }

        if ($me->query('quest') != null) {
            if ($me->query('quest_time') > time()) {
                return false;
            }
            else 
                $me->set('kee', $me->query('kee') /2 + 1);
            $me->del_temp("quest_number");
        }
        
        $tag = 0;
        for ($i = count($levels) - 1; $i >= 0; $i--) {
            if ($levels[$i] <= $exp) {
                $tag = $i;
                break;
            }
        }
        global $QUEST_D;
        $quest = $QUEST_D->query_quest($levels[$tag]);
        $timep = 600;
        $timep = rand(0, $timep) + $timep / 2;
        $chinesetime = $this->time_period($timep);

        if ($quest["quest_type"] == "寻") {
            $ob->ssend($chinesetime . '找回『' . $quest['quest'] . '』给天机老人。');
        } elseif ($quest["quest_type"] == "杀") {
            $ob->ssend($chinesetime . '替天机老人杀了『' . $quest['quest'] . '』。');
        }
        
        $me->set("quest", $quest);
	    $me->set("quest_time", time() + $timep);
        if ($me->query_temp('quest_number') == null)
            $me->set_temp("quest_number", 1);
	    elseif ($me->query_temp("quest_number") < 10)
	        $me->add_temp("quest_number", 1);
        else
            $me->set_temp("quest_number", 1);
        return true;
    }   

    private function time_period($timep)
    {
        $t = $timep;
        $s = intval($t % 60);
        $t /= 60;
        $m = intval($t % 60);
        $t /= 60;
        $h = intval($t % 24);
        $t /= 24;
        $d = intval($t);

        global $CHINESE_D;
        if ($d > 0) 
            $ret = $CHINESE_D->chinese_number($d) . "天";
        else 
            $ret = "";

        if ($h > 0) 
            $ret .= $CHINESE_D->chinese_number($h) . "小时";
        if ($m > 0) 
            $ret .= $CHINESE_D->chinese_number($m) . "分";
        $ret .= $CHINESE_D->chinese_number($s) . "秒";
        return 'HIW' . $this->query('name') . '说道：<br>请在' . $ret . '内NOR';
    }

    public function accept_object($me, $obj)
    {
        $ob = $me->get_conn();
        if ($obj->query('type') == 'money' && $obj->query('value') > 100 && $me->query('quest') != null) {
            $ob->ssend('天机老人说道：好吧，这个任务就算了吧．．');
            $me->del('quest');
            $me->del_temp('quest_number');
            return true;
        }

        if ($me->query('quest') == null) {
            $ob->ssend('天机老人说道：这不是我想要的。');
            return false;
        }

        $quest = $me->query('quest');
        if ($quest['quest'] != $obj->query('name')) {
            $ob->ssend('天机老人说道：这不是我想要的。');
            return false;
        }

        if ($obj->is_character()) {
            $ob->ssend('天机老人说道：这不是我想要的。');
            return false;
        }
        
        if ($me->query('quest_time') < time()) {
            $ob->ssend('天机老人说道：真可惜！你没有在指定的时间内完成！');
            return false;
        }

        $ob->ssend('天机老人说道：恭喜你！你又完成了一项任务！');
        $exp = $quest["exp_bonus"] / 2 + rand(0, $quest["exp_bonus"] / 2) + 1;
	    if ($exp > 150) 
            $exp = 150;
        if ($me->query_temp("quest_number") == null)
            $me->set_temp("quest_number", 1);
	    $exp = $exp * $me->query_temp("quest_number");
	    $pot = $exp / 5 + 1;
	    $score = -1;
	    $me->add("combat_exp", $exp);
	    $me->add("potential", $pot);
	    $me->add("score", $score);
        global $CHINESE_D;
        $ob->ssend('HIW你被奖励了：<br>' . $CHINESE_D->chinese_number($exp) . "点实战经验<br>" . $CHINESE_D->chinese_number($pot) . '点潜能NOR');
	    $me->del("quest");
        $obj->destruct();
        return true;
    }
}
