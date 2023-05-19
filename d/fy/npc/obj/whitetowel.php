<?php
/**
*   白毛巾
*
*/
namespace d\fy\npc\obj;

use std\armor;

class whitetowel extends armor
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'whitetowel');
        $this->set('name', '白毛巾');
        $this->set('long', '一条干干净净的大白毛巾。');
        $this->set('unit', '条');
        $this->set('value', 5000);
        $this->set('type', 'cloth');
        $this->set_weight(1000);
    }
}
