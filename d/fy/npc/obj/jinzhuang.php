<?php
/**
*   黑色劲装
*
*/
namespace d\fy\npc\obj;

use std\armor;

class jinzhuang extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'cloth');
        $this->set('name', '黑色劲装');
        $this->set('unit', '件');
        $this->set('value', 1000);
        $this->set('material', 'cloth');
        $this->set("armor_prop_armor", 2);
        $this->set('type', 'cloth');
        $this->set('long', '这是风云城金狮镖局的招牌衣服。');
        $this->set_weight(3000);
    }
}
