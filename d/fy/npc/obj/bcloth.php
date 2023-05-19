<?php
/**
*   被鲜血浸透的布条
*
*/
namespace d\fy\npc\obj;

use std\armor;

class bcloth extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'piece');
        $this->set('name', 'HIR被鲜血浸透的布条NOR');
        $this->set('unit', '件');
        $this->set('value', 10000);
        $this->set('material', 'cloth');
        $this->set("armor_prop_dodge", -2);
        $this->set('type', 'head');
        $this->set('long', '这是条被鲜血浸透的布条。');
        $this->set_weight(3000);
    }
}
