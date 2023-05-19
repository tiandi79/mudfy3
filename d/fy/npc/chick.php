<?php
/**
*   土娼
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;

class chick extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '土娼');
        $this->set('id', 'girl');
        $this->set('age', 22);
        $this->set('gender', '女性');
        $this->set('long', '土娼是．．．如果你感兴趣的话，请（ｅｎｊｏｙ）．');
        $this->set("combat_exp", 10);
        $this->set("str", 27);
        $this->set("cor", 26);
        $this->set("cps", 25);
	    $this->set("attitude", "friendly");
    }

    public function accept_fight($me = null)
    {
        msg::message_text('say', '小女子哪里是您的对手？', $this);
        return false;
    }

    public function do_enjoy($ob, $arg = null)
    {
        $me = $ob->body;
        msg::message('vision', '$N用手挖了挖鼻孔，然后向$n走过来．．．', $this, $me);
        $env = $me->all_inventory();
        $someplace = $me->get_env();
        foreach ($env as $v) {
            $v->move($someplace);
            $v->destruct();
        }
        msg::message('vision', '$N感觉不错．．．．', $me);
        global $CONDITIONS;
        $this_class = $CONDITIONS->get('hualiu');
        $nexttime = time() + 10;
        $func = 'update_condition';
        $param = array('hualiu', 10 + rand(0, 20));
        $condition = array('next_time' => $nexttime, 'func' => $func, 'param' => $param, 'this_class' => $this_class);
        $me->apply_condition($condition);
        return true;
    }
}
