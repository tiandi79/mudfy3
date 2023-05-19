<?php
/**
*   防具类
*
*/
namespace std;

class armor extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->id = 'armor';
        $this->name = '未命名防具';
        $this->weight = 1;
        $this->unit = '件';
        $this->material = 'cloth';
        $this->armor_prop_armor = 1;
        $this->armor_prop_dodge = 0;
        $this->armor_prop_move = 0;
        $this->type = 'cloth';
    }
}
