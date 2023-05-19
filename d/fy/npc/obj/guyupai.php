<?php
/**
*   古玉牌
*
*/
namespace d\fy\npc\obj;

use std\obj;

class guyupai extends obj
{
    function __construct()
    {
        parent::__construct();
  
        $this->set('id', 'guyupai');
        $this->set('name', '古玉牌');
        $this->set('long', '这块古玉牌上正刻得是先天练气法。');
        $this->set('unit', '块');
        $this->set('value', 1);
        $this->set("material", "stone");
        $this->set('skill', array('name' => 'force', 'exp_required' => 20000, 'sen_cost' => 20, 'difficulty' => 40, 'max_skill' =>80));
        $this->set_weight(600);
    }
}
