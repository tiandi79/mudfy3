<?php
/**
*   风云差服
*
*/
namespace d\fy\npc\obj;

use std\armor;

class yafu extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'cloth');
        $this->set('name', '风云差服');
        $this->set('unit', '件');
        $this->set('value', 1000);
        $this->set('material', 'cloth');
        $this->set("armor_prop_armor", 2);
        $this->set('type', 'cloth');
        $this->set('long', '这是风云城官府用衣服。');
        $this->set_weight(3000);
    }
}
