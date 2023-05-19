<?php
/**
*   scavenger
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;

class scavenger extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '收破烂的');
        $this->set('id', 'scavenger');
        $this->set('age', 47);
        $this->set('gender', '男性');
        $this->set('long', '这个人不但自己收破烂，身上也穿得破烂不堪。');
        $this->set('combat_exp', 10);
        $this->set("str", 27);
	    $this->set("force", 30);
	    $this->set("max_force", 30);
	    $this->set("force_factor", 1);
        $this->set("chat_chance", 2);
        $this->set("chat_msg", array('收破烂的吆喝道：收～破～烂～哪～',
            '收破烂的嘴里嘟哝著，不知道说些什麽。',
            '收破烂的伸手捉住了身上的虱子，一脚踩得扁扁的。'));
        $this->carry_object('/d/fy/npc/obj/oldbook');
        $this->add_money('coin', 5);
    }

    public function accept_fight($me = null)
    {
        global $RANK_D;
        msg::message_text('say', $RANK_D->query_respect($me) . "饶命！小的这就离开！", $me);
        return false;
    }

    public function accept_object($me, $ob)
    {
        global $RANK_D;
        msg::message_text('say', '多些这位' . $RANK_D->query_respect($me) . "！", $me);
        return true;
    }
}
