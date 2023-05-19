<?php
/**
*   王风
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;

class officer extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '王风');
        $this->set('id', 'officer');
        $this->set("age", 42);
        $this->set('title', '风云绎驿长');
        $this->set("gender", "男性" );
        $this->set('long', '王风担任风云驿的驿长已经有几年了，人很好，居民对王风的风评相当不错，常常会来到驿站跟他聊天。');
        $this->set("combat_exp", 800);
        $this->set("attitude", "friendly");
        $this->set_skill("unarmd", 400);
	    $this->set_skill("dodge", 100); 
        $this->set("ironcloth", 200);
        $this->set("inquiry", array('mail' => OPENSOON));
        $this->add_money('silver', 70);
    }    
}
