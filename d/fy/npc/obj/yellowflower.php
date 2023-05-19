<?php
/**
*   黄玫瑰
*
*/
namespace d\fy\npc\obj;

use std\obj;

class yellowflower extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'yellowflower');
        $this->set('name', 'HIY黄玫瑰NOR');
        $this->set('long', '含情脉脉的黄玫瑰。');
        $this->set('unit', '朵');
        $this->set('value', 6);
        $this->set_weight(10);
    }
}
