<?php
/**
*   太极八卦道袍
*
*/
namespace d\fy\npc\obj;

use std\armor;

class daopao extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'cloth');
        $this->set('name', '太极八卦道袍');
        $this->set('unit', '件');
        $this->set('value', 1000);
        $this->set('material', 'cloth');
        $this->set("armor_prop_armor", 2);
        $this->set('type', 'cloth');
        $this->set('long', '这是一件画有太极八卦的袍。');
        $this->set_weight(3000);
    }
}
