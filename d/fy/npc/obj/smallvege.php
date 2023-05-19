<?php
/**
*   小白菜
*
*/
namespace d\fy\npc\obj;

use std\food;

class smallvege extends food
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'small-cabbage');
        $this->set('name', '小白菜');
        $this->set('value', 15);
        $this->set('unit', '个');
        $this->set('long', '一条水灵灵的小白菜。');
        $this->set("food_remaining", 3);
		$this->set("food_supply", 60);
        $this->set_weight(80);
    }
}
