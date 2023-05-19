<?php
/**
*   长鞭
*
*/
namespace obj\obj;

use std\whip;

class longwhip extends whip
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'longwhip');
        $this->set('name', '长鞭');
        $this->set('value', 500);
        $this->set('material', 'skin');
        $this->set('unit', '条');
        $this->set('weapon_prop', 1);
        $this->set('type', 'whip');
        $this->set('skill_type', 'whip');
        $this->set_weight(7000);

        $this->set("wield_msg", '$N从腰间摸出一条$n握在手中。');
        $this->set("unwield_msg", '$N将手中的$n束在腰间。');
    }
}
