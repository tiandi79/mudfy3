<?php
/**
*   金花黄底飞凰袍
*
*/
namespace d\fy\npc\obj;

use std\armor;

class goldcloth extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'jincloth');
        $this->set('name', '金花黄底飞凰袍');
        $this->set('unit', '件');
        $this->set('value', 1000);
        $this->set('material', 'cloth');
        $this->set("armor_prop_armor", 2);
        $this->set('type', 'cloth');
        $this->set('long', '这是件黄色，上面绣满金花和飞舞的凤凰袍。');
        $this->set_weight(3000);
    }
}
