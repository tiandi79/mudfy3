<?php
/**
*   轻功入门
*
*/
namespace d\fy\npc\obj;

use std\obj;

class book4 extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'movebook');
        $this->set('name', '轻功入门');
        $this->set('long', '这本旧书的纸张都已经泛黄了，上面只有一些字迹模糊的字句，似乎提到一些跳跃方法什麽的。');
        $this->set('unit', '本');
        $this->set('value', 70);
        $this->set("material", "paper");
        $this->set('skill', array('name' => 'move', 'exp_required' => 0, 'sen_cost' => 20, 'difficulty' => 20, 'max_skill' =>30));
        $this->set_weight(600);
    }
}
