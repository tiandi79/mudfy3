<?php
/**
*   蓝天鹅
*
*/
namespace d\fy\npc\obj;

use std\obj;

class blueflower extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'blueflower');
        $this->set('name', 'HIB蓝天鹅NOR');
        $this->set('long', '含情脉脉的蓝天鹅。');
        $this->set('unit', '朵');
        $this->set('value', 6);
        $this->set_weight(10);
    }
}
