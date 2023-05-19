<?php
/**
*   风骚雅人
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;

class yaren extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '风骚雅人');
        $this->set('id', 'yaren');
        $this->set("age", 22);
        $this->set("gender", "男性" );
        $this->set('long', '这是一位小有才华的雅人，正在追求灵感。');
        $this->set("combat_exp", 50000);
        $this->set("attitude", "friendly");
        $this->set_skill("hammer", 90);
	    $this->set_skill("dodge", 100); 
        $this->set("ironcloth", 200);
        $this->set("chat_chance", 1);
        $this->set('chat_msg', array('"风骚雅人张了张口，又合上了。',
            '风骚雅人踱来踱去，似乎正在打腹稿。'));

        $this->equip_object('/d/fy/npc/obj/fycloth');
    }    
}
