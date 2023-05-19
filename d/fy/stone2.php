<?php
/**
*  石巷尽头
*
*/
namespace d\fy;

use std\room;

class stone2 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '石巷尽头');
        $this->set('long', '石巷的尽头是一堵高墙，墙上有一道窄门．墙角有一狗洞，一条脏稀稀的小河沟从狗洞中流出．时而不时的，一条条浸满血水的绷带从狗洞中流出．');
        $this->set('exits', array("south" => "fy/stone1",
                             "north" => "fy/sroom"));
        $this->set('coor/x', 10);
        $this->set('coor/y', 20);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');
        $this->create_door("north", "窄门", "south", 1);
        parent::setup_room();
    }
}
