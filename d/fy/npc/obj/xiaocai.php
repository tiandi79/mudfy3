<?php
/**
*   xiaocai
*
*/
namespace d\fy\npc\obj;

use std\food;

class xiaocai extends food
{
    public $name = array('花生', '小黄瓜', '罗卜条');
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'dish');
        $this->set('name', $this->name[rand(0, count($this->name) - 1)]);
        $this->set('value', 2);
        $this->set('unit', '盘');
        $this->set('long', '一盘小菜。');
        $this->set("food_remaining", 5);
		$this->set("food_supply", 6);
        $this->set_weight(350);
    }

    public function finish_eat()
    {
        if (rand(0, 1) == 0)
            $this->set('name', '盘子');
        else
            $this->set('name', '崩了口的小碟儿');
        $this->set('id', 'diezi');
        $this->set('value', 0);
        $this->set("long", "一只小盘子。");
        return true;
    }
}
