<?php
/**
*   铁甲袍
*
*/
namespace questobj;

use std\armor;

class ironrobe extends armor
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'ironrobe');
        $this->set('name', 'HIC铁甲袍NOR');
        $this->set('unit', '件');
        $this->set('material', 'cloth');
        $this->set('armor_prop_armor', 2);
        $this->set('long', '这是一件铁传甲传的袍子。');
        $this->set('istask', 1);
        $this->set_weight(309000);
    }
}
