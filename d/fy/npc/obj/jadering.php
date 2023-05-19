<?php
/**
*   觇玉戒指
*
*/
namespace d\fy\npc\obj;

use std\armor;

class jadering extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'jade-ring');
        $this->set('name', '觇玉戒指');
        $this->set('unit', '枚');
        $this->set('value', 100000);
		$this->set("armor_prop/armor", 0);
		$this->set("armor_prop/personality", 3);
		$this->set('wear_msg', '$N轻轻地把一个$n戴在手指上。');
		$this->set('unwield_msg', '$N轻轻地把$n从手指上除了下来。');
        $this->set('type', 'ring');
        $this->set('long', '一个翠绿欲滴的玉戒指。');
        $this->set_weight(1);
    }
}
