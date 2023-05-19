<?php
/**
*   浅绿小褂
*
*/
namespace d\fy\npc\obj;

use std\armor;

class greencloth extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'cloth');
        $this->set('name', 'HIG浅绿小褂NOR');
        $this->set('unit', '件');
        $this->set('value', 600);
        $this->set('material', 'cloth');
        $this->set("armor_prop_armor", 1);
        $this->set('type', 'cloth');
        $this->set('female_only', 1);
        $this->set('long', '这件浅绿色的小褂上面绣著几只黄鹊，闻起来还有一股淡香。');
        $this->set_weight(1000);
    }
}
