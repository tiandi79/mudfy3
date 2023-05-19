<?php
/**
*   觇玉发簪
*
*/
namespace d\fy\npc\obj;

use std\armor;

class jadepin extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'jade-pin');
        $this->set('name', '觇玉发簪');
        $this->set('unit', '件');
        $this->set('value', 200000);
		$this->set('armor_prop/personality', 3);
		$this->set('wear_msg', '$N轻轻地把一朵$n戴在头上。');
		$this->set('unwield_msg', '$N轻轻地把$n从头上除了下来。');
        $this->set('type', 'head');
        $this->set('long', '一个翠绿欲滴的玉发簪。');
        $this->set_weight(1);
    }
}
