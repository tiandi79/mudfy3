<?php
/**
*   鬼头刀
*
*/
namespace questobj;

use std\blade;

class guiblade extends blade
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'blade');
        $this->set('name', '鬼头刀');
        $this->set('unit', '柄');
        $this->set('weapon_prop', 25);
        $this->set("long", '这种厚重的大刀，强盗喜欢用，份量大约十斤重。');
        $this->set("wield_msg", '$N抽出一把表面斑驳的$n握在手中。');
        $this->set("unequip_msg", '$N将手中的$n插回腰间。');
        $this->set('type', 'blade');
        $this->set('skill_type', 'blade');
        $this->set('istask', 1);
        $this->set_weight(7000);
    }
}
