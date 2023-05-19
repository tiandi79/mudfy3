<?php
/**
*   胭脂
*
*/
namespace d\fy\npc\obj;

use std\obj;

class yanzhi extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'yanzhi');
        $this->set('name', 'HIR胭脂NOR');
        $this->set('long', '鲜红似血的上等胭脂。');
        $this->set('unit', '盒');
        $this->set('value', 1000);
        $this->set_weight(50);
    }
}
