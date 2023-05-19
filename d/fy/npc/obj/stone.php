<?php
/**
*   小石子
*
*/
namespace d\fy\npc\obj;

use std\throwing;

class stone extends throwing
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'stone');
        $this->set('name', '小石子');
        $this->set('long', '一块普通的小石子。');
        $this->set('unit', '堆');
        $this->set('weapon_prop', 1);
        $this->set("base_unit", "粒");
		$this->set("base_weight", 1);
		$this->set("base_value", 1);
        $this->set('type', 'throwing');
        $this->set('skill_type', 'throwing');
        $this->set_amount(50);
        global $CHINESE_D;
        $this->set('short', $CHINESE_D->chinese_number($this->query_amount()) . $this->query('base_unit') . $this->query('name') . '(' . $this->query('id') . ')'); 
    }
}
