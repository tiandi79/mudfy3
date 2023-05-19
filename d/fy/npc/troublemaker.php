<?php
/**
*   troublemaker
*
*/
namespace d\fy\npc;

use std\char;

class troublemaker extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '裸体男人');
        $this->set('id', 'nakedman');
        $this->set('gender', '男性' );
        $this->set('age', 28);
        $this->set('long','这是一位正在洗澡的裸体男人。');
        $this->set('combat_exp', 200000);
        $this->set('attitude', 'aggrensive');
        $this->set_skill('umarmed', 100);
        $this->set_skill("dodge", 100);
        $this->add_money("silver" , 10);
        $this->set_skill("meihuashou", 10);
        $this->set_skill("fallsteps", 10);

        $this->map_skill("unarmed", "meihuashou");
        $this->map_skill("dodge", "fallsteps");
    }
}
