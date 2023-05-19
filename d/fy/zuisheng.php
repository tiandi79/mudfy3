<?php
/**
*  醉生小馆
*
*/
namespace d\fy;

use std\room;

class zuisheng extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '醉生小馆');
        $this->set('long', '这里卖最烈也是最劣的白酒。一杆已经被风扯裂的酒旗上画着一个用红圈起来的“酒”字。几根竹竿撑着一块业已变黑的白帆布，白布下放着几张破旧的木桌和方凳，木桌上零零散散得放着几双木筷和几个崩了口的小碟儿。');
        $this->set('exits', array("north" => "fy/wcloud5"));
        $this->set('objects', array('d/fy/npc/wineowner' => 1));
        $this->set('coor/x', -50);
        $this->set('coor/y', -10);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
