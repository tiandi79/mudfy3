<?php
/**
*   杖类
*
*/
namespace std;

class staff extends weapon
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'staff');
        $this->set('name', '杖');
        $this->set_weight(1);
        $this->set('unit', '把');
        $this->set('material', 'iron');
        $this->set('weapon_prop', 5);
        $this->set('long', '这是一把法杖。');
        $this->set('skill_type', 'staff');
        $this->set('type', 'staff');
        $this->set('verbs', array("bash", "crush", "slam"));
        $this->set('actions', $this->query_action());
    }
}
