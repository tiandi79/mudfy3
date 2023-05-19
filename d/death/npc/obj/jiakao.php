<?php
/**
*   枷铐
*
*/
namespace d\death\npc\obj;

use std\hammer;

class jiakao extends hammer
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'jiakao');
        $this->set('name', 'HIR枷铐NOR');
        $this->set('weight', 8000);
        $this->set('value', 3);
        $this->set('material', 'iron');
        $this->set('long', '这是一副沈重的枷铐，打造的相当坚实。');
        $this->set('unit', '副');
        $this->set('weapon_prop', 65);
        $this->set('type', 'hammer');
        $this->set('skill_type', 'hammer');

        $this->set("wield_msg", '$N拿出一把$n，试了试重量，然後握在手中。');
        $this->set("unwield_msg", '$N放下手中的$n。');
    }
}
