<?php
/**
*   生煎包
*
*/
namespace d\fy\npc\obj;

use std\food;

class baozi4 extends food
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'shengbao');
        $this->set('name', '生煎包');
        $this->set('value', 60);
        $this->set('unit', '个');
        $this->set('long', '一个香喷喷、热腾腾的大包子。');
        $this->set("food_remaining", 3);
		$this->set("food_supply", 30);
        $this->set_weight(90);
    }
}
