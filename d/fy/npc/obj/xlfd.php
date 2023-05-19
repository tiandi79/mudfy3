<?php
/**
*   小李飞刀
*
*/
namespace d\fy\npc\obj;

use std\throwing;

class xlfd extends throwing
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'flying-blade');
        $this->set('name', 'HIR小李飞刀NOR');
        $this->set('long', '一把人见人怕的小李飞刀。');
        $this->set('unit', '堆');
        $this->set('value', 1000);
        $this->set('weapon_prop', 100);
        $this->set("base_unit", "把");
		$this->set("base_weight", 1);
		$this->set("base_value", 1);
        $this->set('type', 'throwing');
        $this->set('skill_type', 'throwing');
        $this->set("wield_msg",'$N不知从哪里突然间拽出一把薄薄的$n握在手里。');
        $this->set_amount(1);
        global $CHINESE_D;
        $this->set('short', $CHINESE_D->chinese_number($this->query_amount()) . $this->query('base_unit') . $this->query('name') . '(' . $this->query('id') . ')'); 
    }
}
