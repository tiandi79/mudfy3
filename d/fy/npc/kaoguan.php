<?php
/**
*   王仁德
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;

class kaoguan extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '王仁德');
        $this->set('id', 'kaoguan');
        $this->set("age", 47);
        $this->set('title', '御封考官');
        $this->set("gender", "男性" );
        $this->set('long', '王仁德是个博学多闻的御封考官，他年轻时曾经中过举人，但是因为生性喜爱年青人不愿做官，王仁德以监考为业，如果你愿学王仁德总是会教的。');
        $this->set("combat_exp", 50000);
        $this->set("attitude", "friendly");
        $this->set_skill("literate", 40);
    }    

    public function recognize_apprentice($me)
    {
        return true;
    }
}
