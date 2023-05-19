<?php
/**
*   觇玉软靴
*
*/
namespace d\fy\npc\obj;

use std\armor;

class jadeboots extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'jade-boots');
        $this->set('name', '觇玉软靴');
        $this->set('unit', '双');
        $this->set('value', 8000);
        $this->set("material", "cloth");
		$this->set("armor_prop/armor", 1);
		$this->set("armor_prop/dodge", 5);
        $this->set('type', 'boots');
        $this->set('long', '这是一双觇玉软靴。');
        $this->set_weight(100);
    }
}
