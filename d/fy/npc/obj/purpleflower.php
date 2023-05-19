<?php
/**
*   紫罗兰
*
*/
namespace d\fy\npc\obj;

use std\obj;

class purpleflower extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'purpleflower');
        $this->set('name', 'HIM紫罗兰NOR');
        $this->set('long', '高贵典雅的紫罗兰，闻起来还有一股淡淡的香味儿。');
        $this->set('unit', '朵');
        $this->set('value', 6);
        $this->set_weight(10);
    }
}
