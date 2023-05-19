<?php
/**
*   烤鸡腿
*
*/
namespace obj\obj;

use std\food;

class chickenleg extends food
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'chicken');
        $this->set('name', '烤鸡腿');
        $this->set('value', 30);
        $this->set('unit', '个');
        $this->set('long', '一枝烤得香喷喷鸡腿，你还犹豫什麽？准备胃液吧。');
        $this->set("food_remaining", 4);
		$this->set("food_supply", 40);
        $this->set_weight(350);
    }

    public function finish_eat()
    {
        $this->set('name', '啃得精光的鸡腿骨头');
        $this->set('id', 'bone');
        $this->set_weight(150);
        $this->set("long", "一根啃得精光的鸡腿骨头。");
        return true;
    }
}
