<?php
/**
*   点点血斑的白袍
*
*/
namespace d\fy\npc\obj;

use std\armor;

class whitecloth extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'whitecloth');
        $this->set('name', 'HIW点点血斑的白袍NOR');
        $this->set('unit', '件');
        $this->set('value', 10000);
        $this->set('material', 'cloth');
        $this->set("armor_prop_armor", 2);
        $this->set('type', 'cloth');
        $this->set('long', '这是件昂贵的白袍但上面布满血斑。');
        $this->set_weight(3000);
    }
}
