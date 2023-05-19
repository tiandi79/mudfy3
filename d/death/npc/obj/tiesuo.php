<?php
/**
*   铁索
*
*/
namespace d\death\npc\obj;

use std\whip;

class tiesuo extends whip
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'tiesuo');
        $this->set('name', 'HIR铁索NOR');
        $this->set('weight', 5000);
        $this->set('value', 500);
        $this->set('material', 'skin');
        $this->set("rigidity",1000);
        $this->set('unit', '条');
        $this->set('long', '这是一条沉重的铁索。');
        $this->set('weapon_prop', 45);
        $this->set('type', 'whip');
        $this->set('skill_type', 'whip');

        $this->set("wield_msg", '$N从腰间摸出一条$n握在手中。');
        $this->set("unwield_msg", '$N将手中的$n束在腰间。');
    }
}
