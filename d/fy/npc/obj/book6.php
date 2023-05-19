<?php
/**
*   符咒入门
*
*/
namespace d\fy\npc\obj;

use std\obj;

class book6 extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'spellsbook');
        $this->set('name', '符咒入门');
        $this->set('long', '这似乎是一本符咒的简介，里面画着一些稀奇古怪的符号。');
        $this->set('unit', '本');
        $this->set('value', 260);
        $this->set("material", "paper");
        $this->set('skill', array('name' => 'spells', 'exp_required' => 100, 'sen_cost' => 30, 'difficulty' => 10, 'max_skill' =>20));
        $this->set_weight(600);
    }
}
