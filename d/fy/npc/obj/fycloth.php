<?php
/**
*   风云马褂
*
*/
namespace d\fy\npc\obj;

use std\armor;

class fycloth extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'cloth');
        $this->set('name', '风云马褂');
        $this->set('unit', '件');
        $this->set('value', 1000);
        $this->set('material', 'cloth');
        $this->set("armor_prop_armor", 2);
        $this->set('type', 'cloth');
        $this->set('long', '这是风云城时下最时髦的衣服。');
        $this->set_weight(3000);
    }
}
