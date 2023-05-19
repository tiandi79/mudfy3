<?php
/**
*   小花裙
*
*/
namespace d\fy\npc\obj;

use std\armor;

class huaskirt extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'xiaoskirt');
        $this->set('name', '小花裙');
        $this->set('unit', '件');
        $this->set('value', 10000);
        $this->set('material', 'cloth');
        $this->set("armor_prop_armor", 3);
        $this->set('type', 'cloth');
        $this->set('long', '一件缀满蓝色小花的裙子。');
        $this->set_weight(3000);
    }
}
