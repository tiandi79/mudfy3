<?php
/**
*   牛头
*
*/
namespace d\fy\npc\obj;

use std\food;

class niutou extends food
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'niutou');
        $this->set('name', '牛头');
        $this->set('value', 2000);
        $this->set('unit', '块');
        $this->set('long', '一块半腐烂的牛头。');
        $this->set("food_remaining", 5);
		$this->set("food_supply", 50);
        $this->set_weight(350);
    }

    public function finish_eat()
    {
        $this->set('name', '牛头骨');
        $this->set('id', 'bone');
        $this->set('value', 1);
        $this->set("long", "一个啃得干干净净的牛头骨。");
        $this->set_max_encumbrance(10);
        global $OBJECT;
        $qu = $OBJECT->create_objects('/d/fy/npc/obj/qu');
        $qu->move($this);
        return true;
    }
}
