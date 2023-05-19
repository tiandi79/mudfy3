<?php
/**
*   风车
*
*/
namespace d\fy\npc\obj;

use std\obj;

class windche extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'toy');
        $this->set('name', '小风车');
        $this->set('long', '一个迎风就会转的小风车。');
        $this->set('unit', '个');
        $this->set('value', 1000);
        $this->set_weight(50);
    }
}
