<?php
/**
*   素菜包
*
*/
namespace d\fy\npc\obj;

use std\food;

class baozi3 extends food
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'subao');
        $this->set('name', '素菜包');
        $this->set('value', 70);
        $this->set('unit', '个');
        $this->set('long', '一个香喷喷、热腾腾的大包子。');
        $this->set("food_remaining", 3);
		$this->set("food_supply", 60);
        $this->set_weight(90);
    }
}
