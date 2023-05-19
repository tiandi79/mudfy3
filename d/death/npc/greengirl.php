<?php
/**
*   绿珠
*
*/
namespace d\death\npc;

use std\msg;
use std\char;

class greengirl extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '绿珠');
        $this->set('id', 'greenpearl');
        $this->set('gender', '女性');
        $this->set('long', '绿珠真是又漂亮又有一种诱人的女人味。你感兴趣的话，请（ｅｎｊｏｙ）。');
        $this->set("age", 22);
        $this->set("str", 10);
	    $this->set("per", 50);
        $this->set("combat_exp", 1000000);
	    $this->set("attitude","friendly");
        $this->is_ghost = true;
    }

    public function accept_fight($me = null)
    {
        msg::message_text('say', '小女子哪里是您的对手？', $me);
        return false;
    }

    public function init_coming($me)
    {
        if ($me->query('divorced') != null) {
            msg::message_text('say', '你这个不从一而终的东西！', $me);
            $this->kill_ob($me);
            $me->kill_ob($this);
            return true;
        }
    }

    public function do_enjoy($ob, $arg = null)
    {
        $me = $ob->body;
        msg::message('vision', '$N轻飘飘地向$n走过来．．．．', $this, $me);
        $this->call_out(3, 'next_stage', $me);
        $me->start_busy(3);
        return true;
    }

    public function next_stage($me)
    {
        if ($me->is_player() && ($me->get_env() == $this->get_env())) {
            msg::message('vision', '$N狠狠地打了$n几个大耳光，骂道：都作鬼了，还那么猥琐，那我就让$n在死几次！！', $this, $me);
            $this->add_temp("apply/attack", 100);
	        $this->add_temp("apply/damage", 50);
            $this->kill_ob($me);
            $me->kill_ob($this);
            return true;
        }
    }
}
