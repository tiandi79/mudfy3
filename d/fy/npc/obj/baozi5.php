<?php
/**
*   小笼包
*
*/
namespace d\fy\npc\obj;

use std\food;

class baozi5 extends food
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'xiaobao');
        $this->set('name', '小笼包');
        $this->set('value', 50);
        $this->set('unit', '个');
        $this->set('long', '一个香喷喷、热腾腾的小笼包。');
        $this->set("food_remaining", 3);
		$this->set("food_supply", 20);
        $this->set_weight(80);
    }
}
