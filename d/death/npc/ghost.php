<?php
/**
*   孤魂野鬼
*
*/
namespace d\death\npc;

use std\msg;
use std\char;

class ghost extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '孤魂野鬼');
        $this->set('id', 'ghost');
        $this->set("age", 45);
        $this->set("str", 24);
        $this->set("cor", 26);
        $this->set("env/wimpy", 70);
        $this->set_temp("apply/attack", 10);
        $this->set_temp("apply/armor", 3);
        //$this->set("chat_chance", 10);
        //$this->set('chat_msg', array(':random_move'));
        $this->is_ghost = true;
    }
    
    
}
