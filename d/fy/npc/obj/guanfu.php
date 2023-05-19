<?php
/**
*   知府团龙官服
*
*/
namespace d\fy\npc\obj;

use std\armor;

class guanfu extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'guanfu');
        $this->set('name', '知府团龙官服');
        $this->set('unit', '件');
        $this->set('value', 1000);
        $this->set('material', 'cloth');
        $this->set("armor_prop_armor", 2);
        $this->set('type', 'cloth');
        $this->set('long', '这是风云知府官服。');
        $this->set_weight(3000);
    }
}
