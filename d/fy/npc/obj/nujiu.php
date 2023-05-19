<?php
/**
*   大酒袋
*
*/
namespace d\fy\npc\obj;

use std\liquid;

class nujiu extends liquid
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'quskin');
        $this->set('name', '大酒袋');
        $this->set('value', 20);
        $this->set('unit', '个');
        $this->set('long', '一个牛皮缝的大酒袋，大概装得八、九升的酒。');
		$this->set("max_liquid", 15);
        $this->set_weight(700);
        $this->set("liquid", array("type" => "alcohol", "name" => "最劣的白酒", "remaining" => 15, "drunk_apply" => 30));
    }
}
