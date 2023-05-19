<?php
/**
*  倾城胭脂店
*
*/
namespace d\fy;

use std\room;

class qcyzdian extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '倾城胭脂店');
        $this->set('long', '这里陈列着各式各样的胭脂，有从京都运来的，也有本地产的。胭脂鲜红似血,香气扑鼻。每当朝阳初升，阳光照入店内，映在胭脂上，给人一种耀眼的亮红。除了胭脂这里来卖刨花油，花粉袋。店老板听说就是当年江湖中有名的易容高手。');
        $this->set('exits', array("east" => "fy/nwind2"));
        $this->set('objects', array("fy/npc/makeupseller" => 1,
            "fy/npc/younggirl" => 2));
        $this->set('coor/x', -10);
        $this->set('coor/y', 20);
        $this->set('coor/z', 0);
        
        parent::setup_room();
    }
}
