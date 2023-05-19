<?php
/**
*   mask
*
*/
namespace d\fy\npc\obj;

use std\armor;

class mask extends armor
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'skinmask');
        $this->set('name', '人皮面具');
        $this->set('long', '一张人皮面具。');
        $this->set('unit', '张');
        $this->set('type', 'mask');
        $this->set('value', 0);
        $this->set_weight(600);
    }
}
