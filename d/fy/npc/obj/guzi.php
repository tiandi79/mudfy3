<?php
/**
*   鹘子
*
*/
namespace d\fy\npc\obj;

use std\throwing;

class guzi extends throwing
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'guzi');
        $this->set('name', '鹘子');
        $this->set('long', '一颗晶滢剔透的象牙骰子。');
        $this->set('unit', '堆');
        $this->set('weapon_prop', 1);
        $this->set("base_unit", "粒");
		$this->set("base_weight", 1);
		$this->set("base_value", 1);
        $this->set('type', 'throwing');
        $this->set('skill_type', 'throwing');
        $this->set_amount(88);
        global $CHINESE_D;
        $this->set('short', $CHINESE_D->chinese_number($this->query_amount()) . $this->query('base_unit') . $this->query('name') . '(' . $this->query('id') . ')'); 
    }
}
