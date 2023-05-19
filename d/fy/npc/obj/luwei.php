<?php
/**
*   卤味儿
*
*/
namespace d\fy\npc\obj;

use std\food;

class luwei extends food
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'luwei');
        $this->set('name', '卤味儿');
        $this->set('value', 1000);
        $this->set('unit', '盘');
        $this->set('long', '一盘上好的卤味儿。');
        $this->set("food_remaining", 5);
		$this->set("food_supply", 50);
        $this->set_weight(350);
    }

    public function finish_eat()
    {
        $this->set('name', '盘子');
        $this->set('id', 'panzi');
        $this->set('value', 200);
        $this->set("long", "一只蓝底儿雕花的盘子。");
        return true;
    }
}
