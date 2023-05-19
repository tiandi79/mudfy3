<?php
/**
*   泥人
*
*/
namespace d\fy\npc\obj;

use std\obj;

class niren extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'niren');
        $this->set('name', '泥人');
        $this->set('long', '一个制作精巧的彩色泥人儿。');
        $this->set('unit', '个');
        $this->set('value', 100);
        $this->set_weight(50);
    }
}
