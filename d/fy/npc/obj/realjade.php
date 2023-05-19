<?php
/**
*   罗刹牌
*
*/
namespace d\fy\npc\obj;

use std\obj;

class realjade extends obj
{
    function __construct()
    {
        parent::__construct();
  
        $this->set('id', 'luosha');
        $this->set('name', '罗刹牌');
        $this->set('long', '这块真罗刹牌上正刻得是天师正道。');
        $this->set('unit', '块');
        $this->set('value', 1);
        $this->set("material", "stone");
        $this->set('skill', array('name' => 'taoism', 'exp_required' => 20000, 'sen_cost' => 20, 'difficulty' => 40, 'max_skill' =>40));
        $this->set_weight(600);
    }
}
