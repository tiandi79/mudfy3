<?php
/**
*  阴暗石巷
*
*/
namespace d\fy;

use std\room;

class stone1 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '阴暗石巷');
        $this->set('long', '石巷散发着一种奇怪的霉腐味道．又加杂着一丝血腥．和干净宽敞的东云大路格格不入．一条又脏又臭的小河沟顺着巷侧缓缓流淌．上面还漂
着染满着黑血的绷带．');
        $this->set('exits', array("south" => "fy/ecloud1",
                             "north" => "fy/stone2"));
        $this->set('objects', array("fy/npc/scavenger" => 1));
        $this->set('coor/x', 10);
        $this->set('coor/y', 15);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');

        parent::setup_room();
    }
}
