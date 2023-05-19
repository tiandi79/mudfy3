<?php
/**
*   煮熟了的蛆
*
*/
namespace d\fy\npc\obj;

use std\obj;

class qu extends obj
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'qu');
        $this->set('name', '煮熟了的蛆');
        $this->set('value', 0);
        $this->set('unit', '条');
        $this->set('long', '一条白白的煮熟了的蛆。');
        $this->set_weight(1);
    }
}
