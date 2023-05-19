<?php
/**
*   货票
*
*/
namespace d\fy\npc\obj;

use std\obj;

class huopiao extends obj
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'huopiao');
        $this->set('name', '货票');
        $this->set('value', 1);
        $this->set('unit', '张');
        $this->set('long', '一张金狮镖局的货票。');
        $this->set_weight(50);
    }
}
