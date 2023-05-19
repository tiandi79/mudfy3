<?php
/**
*   包子
*
*/
namespace obj\obj;

use std\food;

class dumpling extends food
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'dumpling');
        $this->set('name', '包子');
        $this->set('value', 15);
        $this->set('unit', '个');
        $this->set('long', '一个香喷喷、热腾腾的大包子。');
        $this->set("food_remaining", 3);
		$this->set("food_supply", 60);
        $this->set_weight(80);
    }
}
