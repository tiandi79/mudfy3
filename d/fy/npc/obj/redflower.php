<?php
/**
*   红玫瑰
*
*/
namespace d\fy\npc\obj;

use std\obj;

class redflower extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'redflower');
        $this->set('name', 'HIR红玫瑰NOR');
        $this->set('long', '热奔奔放的红玫瑰。');
        $this->set('unit', '朵');
        $this->set('value', 6);
        $this->set_weight(10);
    }
}
