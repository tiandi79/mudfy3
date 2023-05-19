<?php
/**
*   花粉袋
*
*/
namespace d\fy\npc\obj;

use std\obj;

class huabag extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'huabag');
        $this->set('name', '花粉袋');
        $this->set('long', '气味芳香的花粉袋。');
        $this->set('unit', '个');
        $this->set('value', 1000);
        $this->set_weight(50);
    }
}
