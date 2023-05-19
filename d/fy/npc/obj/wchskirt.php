<?php
/**
*   紧身裙
*
*/
namespace d\fy\npc\obj;

use std\armor;

class wchskirt extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'miniskirt');
        $this->set('name', 'HIY五NORHIR彩NOR紧身裙');
        $this->set('unit', '件');
        $this->set('value', 10000);
        $this->set('material', 'cloth');
        $this->set("armor_prop_armor", 3);
        $this->set('type', 'cloth');
        $this->set('long', '一件五彩丝编成的紧身裙。');
        $this->set_weight(3000);
    }
}
