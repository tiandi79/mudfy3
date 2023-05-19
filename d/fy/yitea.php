<?php
/**
*  一品居
*
*/
namespace d\fy;

use std\room;

class yitea extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '一品居');
        $this->set('long', '各地的名茶这里都有的卖。这里冲茶的水也是从枫叶泉专程汲来的。这里冲茶的壶更是名贵的紫砂壶。这里冲茶的方法也是最讲究的。每壶茶的第一杯是用来养壶的。所以这里冲出的茶都有一种纯厚的香气。');
        $this->set('exits', array("west" => "fy/swind3",
            "up" => "fy/yitea2"));
        $this->set('objects', array("fy/npc/teawaiter" => 1));
        $this->set('coor/x', 10);
        $this->set('coor/y', -30);
        $this->set('coor/z', 0);
        
        parent::setup_room();
    }
}
