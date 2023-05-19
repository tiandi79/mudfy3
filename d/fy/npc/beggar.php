<?php
/**
*   老乞丐
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;

class beggar extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '老乞丐');
        $this->set('id', 'begger');
        $this->set('age', 55);
        $this->set('gender', '男性');
        $this->set('long', '一个满脸风霜之色的老乞丐。');
        $this->set("combat_exp", 10);
        $this->set("str", 27);
        $this->set("cor", 26);
        $this->set("cps", 25);
	    $this->set("attitude", "friendly");
        $this->set('family', array('family_name' => '丐帮',
                'generation' => 12,
                'identity' => '弟子',
                'family_master' => null));
	    $this->set("title", "丐帮一袋弟子");
        $this->set_skill("begging", rand(0, 100) + 10);
        $this->set("chat_chance", 15);
        $this->set("chat_msg", array('老乞丐说道：好心的大爷哪～ 赏我要饭的几文钱吧～'));
    }

    public function init_coming($me)
    {
        if (!$this->is_fighting()) {
            $this->call_out(1, 'greating', $me);
        }
    }

    public function greating($me)
    {
        $this->timerid = null;
        if ($me->is_player() && $this->is_environment($me->query('id'))) {
            global $DEFAULT_CONN;
            $DEFAULT_CONN->init($this);
            $this->do_cmd($DEFAULT_CONN, 'beg silver from ' . $me->id);
        }
    }

    public function accept_object($me, $obj)
    {
        global $DEFAULT_CONN, $RANK_D;
        $DEFAULT_CONN->init($this);
        $this->do_cmd($DEFAULT_CONN, 'smile');
        $this->do_cmd($DEFAULT_CONN, 'say 多谢这位' . $RANK_D->query_respect($me) . '，您好心一定会有好报的！');
        return true;
    }

    public function accept_fight($me = null)
    {
        global $DEFAULT_CONN, $RANK_D;
        $DEFAULT_CONN->init($this);
        $this->do_cmd($DEFAULT_CONN, 'smile');
        $this->do_cmd($DEFAULT_CONN, 'say ' . $RANK_D->query_respect($me) . '饶命！小的这就离开！');
        return false;
    }
}
