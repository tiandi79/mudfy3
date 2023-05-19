<?php
/**
*   银花青底披肩袍
*
*/
namespace d\fy\npc\obj;

use std\armor;

class yincloth extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'yincloth');
        $this->set('name', '银花青底披肩袍');
        $this->set('unit', '件');
        $this->set('value', 1000);
        $this->set('material', 'cloth');
        $this->set("armor_prop_armor", 2);
        $this->set('type', 'cloth');
        $this->set('long', '这是青色上有小花的披肩袍。');
        $this->set_weight(3000);
    }
}
