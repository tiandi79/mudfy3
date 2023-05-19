<?php
/**
*   杀威棒
*
*/
namespace d\fy\npc\obj;

use std\staff;

class sawei extends staff
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'shawei');
        $this->set('name', '杀威棒');
        $this->set('value', 620);
        $this->set('long', '一条又粗又长的木制杀威棒，两头红色。');
        $this->set('unit', '条');
        $this->set('weapon_prop', 33);
        $this->set('type', 'staff');
        $this->set("material", "wood");
        $this->set('skill_type', 'staff');
        $this->set('wield_msg', '$N拿出一根两头红色的$n握在手中。');
		$this->set('unwield_msg', '$N放下手中的$n。');
        $this->set_weight(8000);
    }
}
