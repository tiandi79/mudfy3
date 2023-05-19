<?php
/**
*  飘香花店
*
*/
namespace d\fy;

use std\room;

class pxhdian extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '飘香花店');
        $this->set('long', '未入此处，清新的花香已沁人心裨。店中各种名花，玲琅满目，不乏珍奇异种。来客不分高低贵贱，这里的主人总是笑脸相迎。许多城中的年青人都喜欢在这儿逗留，盼有一天桃花运会降临在他身上。据这里的老板说，在飘香花店结成的良缘已不可胜数。');
        $this->set('exits', array("west" => "fy/nwind2"));
        $this->set('objects', array("fy/npc/flowerseller" => 1,
            "fy/npc/youngman" => 2));
        $this->set('coor/x', 1);
        $this->set('coor/y', 20);
        $this->set('coor/z', 0);
        
        parent::setup_room();
    }
}
