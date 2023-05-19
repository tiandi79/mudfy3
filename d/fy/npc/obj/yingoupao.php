<?php
/**
*   银钩袍
*
*/
namespace d\fy\npc\obj;

use std\armor;

class yingoupao extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'robe');
        $this->set('name', '银钩袍');
        $this->set('unit', '件');
        $this->set('value', 1);
        $this->set('material', 'cloth');
        $this->set('armor_prop_armor', 2);
        $this->set('type', 'cloth');
        $this->set_weight(10000);
    }
}
