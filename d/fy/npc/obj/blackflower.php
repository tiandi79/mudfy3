<?php
/**
*   黑牡丹
*
*/
namespace d\fy\npc\obj;

use std\obj;

class blackflower extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'blackflower');
        $this->set('name', 'BLU黑牡丹NOR');
        $this->set('long', '清高冷傲的黑牡丹。');
        $this->set('unit', '朵');
        $this->set('value', 6);
        $this->set_weight(10);
    }
}
