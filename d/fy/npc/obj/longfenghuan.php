<?php
/**
*   龙凤双环
*
*/
namespace d\fy\npc\obj;

use std\hammer;

class longfenghuan extends hammer
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'longfeng');
        $this->set('name', '龙凤双环');
        $this->set('long', '这是一套龙凤双环，上官的成名兵器。');
        $this->set('unit', '个');
        $this->set('weapon_prop', 125);
        $this->set('type', 'hammer');
        $this->set('skill_type', 'hammer');
        $this->set('value', 30000);
        $this->set('rigidity', 999999);
        $this->set('wield_msg', '$N双手一分，拿出一双$n握在手中。');
		$this->set('unwield_msg', '$N放下手中的$n。');
        $this->set_weight(2000);
    }
}
