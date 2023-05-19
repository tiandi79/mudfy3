<?php
/**
*   剑类
*
*/
namespace std;

class sword extends weapon
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'sword');
        $this->set('name', '剑');
        $this->set_weight(1);
        $this->set('unit', '把');
        $this->set('material', 'steel');
        $this->set('weapon_prop', 5);
        $this->set('long', '这是一把普通的剑。');
        $this->set('skill_type', 'sword');
        $this->set('type', 'sword');
        $this->set('verbs', array("slash", "slice", "thrust"));
        $this->set('actions', $this->query_action());
    }
}
