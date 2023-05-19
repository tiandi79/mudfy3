<?php
/**
*   大青菜
*
*/
namespace d\fy\npc\obj;

use std\food;

class bigvege extends food
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'big-cabbage');
        $this->set('name', '大青菜');
        $this->set('value', 25);
        $this->set('unit', '个');
        $this->set('long', '一条水灵灵的大青菜。');
        $this->set("food_remaining", 3);
		$this->set("food_supply", 60);
        $this->set_weight(80);
    }
}
