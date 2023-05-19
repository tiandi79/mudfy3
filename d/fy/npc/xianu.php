<?php
/**
*   裸体女人
*
*/
namespace d\fy\npc;

use std\char;

class xianu extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '裸体女人');
        $this->set('id', 'nakedgirl');
        $this->set('gender', '女性' );
        $this->set('age', 19);
        $this->set('long','这是一位正在以枫叶泉水疗伤的女人。');
        $this->set('combat_exp', 700);
        $this->set('attitude', 'friendly');
        $this->set_skill('umarmed', 10);
        $this->set_skill("dodge", 100);
        $this->set_skill("meihuashou", 10);
        $this->set_skill("fallsteps", 10);

        $this->map_skill("unarmed", "meihuashou");
        $this->map_skill("dodge", "fallsteps");
    }
}
