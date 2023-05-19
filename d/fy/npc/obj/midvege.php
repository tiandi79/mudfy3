<?php
/**
*   胡萝卜
*
*/
namespace d\fy\npc\obj;

use std\food;

class midvege extends food
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'carrot');
        $this->set('name', '胡萝卜');
        $this->set('value', 35);
        $this->set('unit', '个');
        $this->set('long', '一条红红，又香又脆的胡萝卜。');
        $this->set("food_remaining", 3);
		$this->set("food_supply", 60);
        $this->set_weight(80);
    }
}
