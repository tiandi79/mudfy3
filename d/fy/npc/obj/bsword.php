<?php
/**
*   雅乌古剑
*
*/
namespace d\fy\npc\obj;

use std\sword;

class bsword extends sword
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'darksword');
        $this->set('name', '雅乌古剑');
        $this->set('value', 400);
        $this->set('long', '这是一把看起古朴而又锋利的剑。');
        $this->set('unit', '把');
        $this->set('weapon_prop', 35);
        $this->set('type', 'sword');
        $this->set("material", "steel");
        $this->set('skill_type', 'sword');
        $this->set('wield_msg', '$N「唰」地一声把$n握在手中。');
		$this->set('unwield_msg', '$N将手中的$n插入腰间的剑鞘。');
        $this->set_weight(7000);
    }
}
