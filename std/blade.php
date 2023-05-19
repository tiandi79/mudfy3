<?php
/**
*   刀类
*
*/
namespace std;

class blade extends weapon
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'blade');
        $this->set('name', '刀');
        $this->set_weight(1);
        $this->set('unit', '把');
        $this->set('material', 'steel');
        $this->set('weapon_prop', 5);
        $this->set('long', '这是一把普通的刀。');
        $this->set('skill_type', 'blade');
        $this->set('type', 'blade');
        $this->set('verbs', array("slash", "slice", "hack"));
        $this->set('actions', $this->query_action());
    }
}
