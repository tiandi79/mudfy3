<?php
/**
*   银甲
*
*/
namespace d\death\npc\obj;

use std\armor;

class silverarmor extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'yinjia');
        $this->set('name', 'HIW银甲NOR');
        $this->set('unit', '件');
        $this->set("material", "silver");
		$this->set("value", 9000);
		$this->set("armor_prop_armor", 40);
		$this->set("armor_prop_dodge", -20);
        $this->set('type', 'cloth');
        $this->set('long', '一件银盔甲。');
        $this->set_weight(50000);
    }
}
