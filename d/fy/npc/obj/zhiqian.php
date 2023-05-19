<?php
/**
*   纸钱
*
*/
namespace d\fy\npc\obj;

use std\obj;

class zhiqian extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'zhiqian');
        $this->set('name', '纸钱');
        $this->set('long', '一串纸钱。');
        $this->set('unit', '串');
        $this->set('value', 1000);
        $this->set_weight(50);
    }
}
