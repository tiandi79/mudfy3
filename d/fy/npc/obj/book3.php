<?php
/**
*   内功心法
*
*/
namespace d\fy\npc\obj;

use std\obj;

class book3 extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'neibook');
        $this->set('name', '内功心法');
        $this->set('long', '这本旧书的纸张都已经泛黄了，上面只有一些字迹模糊的字句，似乎提到一些呼吸方法什麽的。');
        $this->set('unit', '本');
        $this->set('value', 70);
        $this->set("material", "paper");
        $this->set('skill', array('name' => 'force', 'exp_required' => 0, 'sen_cost' => 30, 'difficulty' => 20, 'max_skill' =>10));
        $this->set_weight(600);
    }
}
