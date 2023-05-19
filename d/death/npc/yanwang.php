<?php
/**
*   阎王爷
*
*/
namespace d\death\npc;

use std\msg;
use std\char;

class yanwang extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '阎王爷');
        $this->set('id', 'death-god');
        $this->set("nickname", 'HIR黑面君王NOR');
        $this->set('gender', '男性');
        $this->set('long', '阎王爷说道：＂不准乱看！');
        $this->set("str", 100);
        $this->set("cor", 37);
        $this->set('age', 5100);
        $this->set("attitude", "peaceful");
        $this->set("chat_chance", 15);
        $this->set("chat_msg", array('判官喝道：牛头，马面何在？'));
        $this->set("combat_exp", 20000000);
        $this->set_temp("apply/attack", 80);
        $this->set_temp("apply/parry", 80);	    
        $this->set_temp("apply/dodge", 70);
	    $this->set_skill("move", 200);
        $this->set('inquiry', array('投胎' => '排好队，慢慢来。', '*' => '你的废话真够多的！人都死了，嘴还不肯闭上。'));
    }

    public function unconcious()
    {
        return false;
    }

    public function die()
    {
        return false;
    }
}
