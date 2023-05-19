<?php
/**
*   鞭类
*
*/
namespace std;

class whip extends weapon
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'whip');
        $this->set('name', '鞭');
        $this->set_weight(1);
        $this->set('unit', '条');
        $this->set('material', 'skin');
        $this->set('weapon_prop', 5);
        $this->set('long', '这是一条普通的鞭子。');
        $this->set('skill_type', 'whip');
        $this->set('type', 'whip');
        $this->set('verbs', array("whip"));
        $this->set('actions', $this->query_action());
    }
}
