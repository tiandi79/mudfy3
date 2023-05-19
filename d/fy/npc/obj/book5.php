<?php
/**
*   魔法简介
*
*/
namespace d\fy\npc\obj;

use std\obj;

class book5 extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'magicbook');
        $this->set('name', '魔法简介');
        $this->set('long', '这似乎是一本魔法的入门书，里面说了一些稀奇古怪的和一般的武学不同的东西。');
        $this->set('unit', '本');
        $this->set('value', 260);
        $this->set("material", "paper");
        $this->set('skill', array('name' => 'magic', 'exp_required' => 100, 'sen_cost' => 30, 'difficulty' => 10, 'max_skill' =>20));
        $this->set_weight(600);
    }
}
