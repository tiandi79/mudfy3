<?php
/**
*   长杆旱烟枪
*
*/
namespace d\fy\npc\obj;

use std\dagger;

class hanyan extends dagger
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'hanyan');
        $this->set('name', '长杆旱烟枪');
        $this->set('long', '这是一把烟锅又拳头大小的长杆旱烟枪。');
        $this->set('unit', '把');
        $this->set('weapon_prop', 25);
        $this->set('type', 'dagger');
        $this->set('skill_type', 'dagger');
        $this->set('wield_msg', '$N「唰」地一声把$n握在手中。');
		$this->set('unwield_msg', '$N将手中的$n插回腰间。');
        $this->set_weight(7000);
    }
}
