<?php
/**
*   成都蛋汤
*
*/
namespace d\fy\npc\obj;

use std\liquid;

class cddt extends liquid
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'dawan');
        $this->set('name', '青瓷大碗');
        $this->set('value', 1000);
        $this->set('unit', '个');
        $this->set('long', '一个精工制作的景太蓝大碗。');
        $this->set("max_liquid", 5);
        $this->set_weight(700);
        $this->set("liquid", array("type" => "soup", "name" => "成都蛋汤", "remaining" => 5, "drunk_apply" => 0));
    }
}
