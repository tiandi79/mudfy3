<?php
/**
*   茶花
*
*/
namespace d\fy\obj;

use std\throwing;

class flower extends throwing
{
    function __construct()
    {
        global $CHINESE_D;
        parent::__construct();
        $this->set('id', 'flower');
        $this->set('name', '茶花');
        $this->set('unit', '把');
        $this->set('long', '洁白的山茶花，发出一股淡淡的香气。');
        $this->set("base_weight", 1);
		$this->set("base_value", 1);
        $this->set("base_unit", "朵");
        $this->set_amount(2);
        $this->set('short', $CHINESE_D->chinese_number($this->query_amount()) . $this->query('base_unit') . $this->query('name') . '(' . $this->query('id') . ')'); 
        $this->set('weapon_prop', 1);
    }
}
