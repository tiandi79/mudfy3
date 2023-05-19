<?php
/**
*   竹刀
*
*/
namespace d\fy\npc\obj;

use std\blade;

class bblade extends blade
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'blade');
        $this->set('name', '竹刀');
        $this->set('value', 200);
        $this->set('long', '这是一把练习刀法用的竹刀，刀口处用布包了起来以免误伤同伴。');
        $this->set('unit', '把');
        $this->set('weapon_prop', 20);
        $this->set('type', 'blade');
        $this->set("material", "bamboo");
        $this->set('skill_type', 'blade');
        $this->set('wield_msg', '$N拿出一把练刀用的$n，握在手中。');
		$this->set('unwield_msg', '$N放下手中的$n。');
        $this->set_weight(1000);
    }
}
