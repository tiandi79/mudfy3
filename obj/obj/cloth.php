<?php
/**
*   布衣
*
*/
namespace obj\obj;

use std\armor;

class cloth extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'cloth');
        $this->set('name', '布衣');
        $this->set('unit', '件');
        $this->set('material', 'cloth');
        $this->set('armor_prop_armor', 1);
        $this->set('long', '这是一件普通的衣服。');
        $this->set_weight(3000);
    }
}
