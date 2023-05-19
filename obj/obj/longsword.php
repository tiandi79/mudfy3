<?php
/**
*   长剑
*
*/
namespace obj\obj;

use std\sword;

class longsword extends sword
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'longsword');
        $this->set('name', '长剑');
        $this->set('unit', '把');
        $this->set('weapon_prop', 25);
        $this->set('type', 'sword');
        $this->set('skill_type', 'sword');
        $this->set('value', 500);
        $this->set_weight(7000);
    }
}
