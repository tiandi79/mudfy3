<?php
/**
*   忏悔徒
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;
use \Workerman\Lib\Timer;

class chantou extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '忏悔徒');
        $this->set('id', 'chantu');
        $this->set('title', '泪流满面');
        $this->set('gender', '女性' );
        $this->set('age', 19);
        $this->set('long','一个泪流满面的忏悔徒。');
        $this->set('combat_exp', 700);
        $this->set('attitude', 'friendly');
        $this->set("max_kee",400);
	    $this->set("eff_kee",400);
	    $this->set("kee",400);
        $this->set_skill("unarmed", 10);
        $this->set_skill("parry", 25);
	    $this->set_skill("dodge", 100);

        $this->equip_object('/obj/obj/cloth');
    }


}
