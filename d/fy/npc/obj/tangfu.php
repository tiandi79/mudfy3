<?php
/**
*   金钱袍
*
*/
namespace d\fy\npc\obj;

use std\armor;

class tangfu extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'cloth');
        $this->set('name', '金钱袍');
        $this->set('unit', '件');
        $this->set('value', 1000);
        $this->set('material', 'cloth');
        $this->set("armor_prop_armor", 2);
        $this->set('type', 'cloth');
        $this->set('long', '这是金钱帮的招牌衣服。');
        $this->set_weight(3000);
    }
}
