<?php
/**
*   锤类
*
*/
namespace std;

class hammer extends weapon
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'hammer');
        $this->set('name', '锤');
        $this->set_weight(1);
        $this->set('unit', '把');
        $this->set('material', 'iron');
        $this->set('weapon_prop', 5);
        $this->set('long', '这是一把大锤子。');
        $this->set('skill_type', 'hammer');
        $this->set('type', 'hammer');
        $this->set('verbs', array("bash", "crush", "slam"));
        $this->set('actions', $this->query_action());
    }
}
