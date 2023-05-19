<?php
/**
*   吴青
*
*/
namespace d\fy\npc;

use std\char;

class tiemian extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '吴青');
        $this->set('id', 'wuqing');
        $this->set('age', 32);
        $this->set('gender', '男性');
        $this->set('long', '一个精明能干，武功高强的赏罚堂堂主。');
        $this->set("combat_exp", 9999999);
	    $this->set("attitude", "friendly");
	    $this->set("max_atman", 300);
        $this->set("atman", 300);
        $this->set("max_force", 300);
        $this->set("force", 300);
        $this->set("max_mana", 300);
        $this->set("mana", 300);
        $this->set("force_factor", 20);

        $this->set_skill("unarmed", 100);
        $this->set_skill("dodge", 100);
        $this->set_skill("force", 130);
        $this->set_skill("literate", 70);

        $this->set_skill("qidaoforce", 100);
        $this->set_skill("meihuashou", 10);
        $this->set_skill("fallsteps", 100);

        $this->map_skill("unarmed", "meihuashou");
        $this->map_skill("dodge", "fallsteps");
        $this->equip_object('/d/fy/npc/obj/tangfu');
    }

    public function accept_object($me, $obj)
    {
        global $DEFAULT_CONN;
        $DEFAULT_CONN->init($this);
        $this->do_cmd($DEFAULT_CONN, 'grin');
        $this->do_cmd($DEFAULT_CONN, 'say 瞎了眼的狗才，竟敢贿赂我？？');
        $this->kill_ob($me);
        return false;
    }
}
