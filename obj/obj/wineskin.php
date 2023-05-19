<?php
/**
*   牛皮酒袋
*
*/
namespace obj\obj;

use std\liquid;

class wineskin extends liquid
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'wineskin');
        $this->set('name', '牛皮酒袋');
        $this->set('value', 20);
        $this->set('unit', '个');
        $this->set('long', '一个牛皮缝的大酒袋。');
		$this->set("max_liquid", 15);
        $this->set_weight(700);
        $this->set("liquid", array("type" => "alcohol", "name" => "红酒", "remaining" => 15, "drunk_apply" => 6));
    }
}
