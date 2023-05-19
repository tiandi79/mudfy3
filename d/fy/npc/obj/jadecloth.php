<?php
/**
*   觇玉羽衣
*
*/
namespace d\fy\npc\obj;

use std\armor;

class jadecloth extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'jade-cloth');
        $this->set('name', '觇玉羽衣');
        $this->set('unit', '件');
        $this->set('value', 40000);
        $this->set('material', 'cloth');
        $this->set('armor_prop_armor', 10);
        $this->set('armor_prop_dodge', 5);
        $this->set('type', 'cloth');
        $this->set_weight(1000);
    }
}
