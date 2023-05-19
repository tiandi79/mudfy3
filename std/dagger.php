<?php
/**
*   短兵类
*
*/
namespace std;

class dagger extends weapon
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'dagger');
        $this->set('name', '匕首');
        $this->set_weight(1);
        $this->set('unit', '把');
        $this->set('material', 'steel');
        $this->set('weapon_prop', 5);
        $this->set('long', '这是一把普通的匕首。');
        $this->set('skill_type', 'dagger');
        $this->set('type', 'dagger');
        $this->set('verbs', array("slice", "pierce", "thrust"));
        $this->set('actions', $this->query_action());
    }
}
