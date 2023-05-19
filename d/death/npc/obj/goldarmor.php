<?php
/**
*   金盔
*
*/
namespace d\death\npc\obj;

use std\armor;

class goldarmor extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'jinkui');
        $this->set('name', 'HIY金盔NOR');
        $this->set('unit', '顶');
        $this->set("material", "gold");
		$this->set("value", 9000);
		$this->set("armor_prop_armor", 50);
		$this->set("armor_prop_dodge", -20);
        $this->set('type', 'head');
        $this->set('long', '一顶金色的帽子。');
        $this->set_weight(50000);
    }
}
