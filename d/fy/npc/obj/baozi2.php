<?php
/**
*   鸭油包
*
*/
namespace d\fy\npc\obj;

use std\food;

class baozi2 extends food
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'yabao');
        $this->set('name', '鸭油包');
        $this->set('value', 90);
        $this->set('unit', '个');
        $this->set('long', '一个香喷喷、热腾腾的大包子。');
        $this->set("food_remaining", 3);
		$this->set("food_supply", 60);
        $this->set_weight(90);
    }
}
