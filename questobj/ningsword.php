<?php
/**
*   凝碧剑
*
*/
namespace questobj;

use std\sword;

class ningsword extends sword
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'ningsword');
        $this->set('name', '凝碧剑');
        $this->set('unit', '把');
        $this->set('weapon_prop', 75);
        $this->set("long", '一个枯梅大师常配带的剑。');
        $this->set("wield_msg", '$N抽出一把$n握在手中。');
        $this->set("unequip_msg", '$N将手中的$n插回鞘内。');
        $this->set('type', 'sword');
        $this->set('skill_type', 'sword');
        $this->set('istask', 1);
        $this->set_weight(7000);
    }
}
