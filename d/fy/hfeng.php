<?php
/**
*  浣凰堂
*
*/
namespace d\fy;

use std\room;

class hfeng extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '浣凰堂');
        $this->set('long', '四面的墙壁挂满了风干的花环，散发出醉人的香气。大堂的中央是一个古色古香的青铜仙鹤，鹤嘴里面飘出袅袅青烟，沁人心脾。大堂的右边是一个小小的柜台，台子的后面有一个木架，架子上挂满了白毛巾。');
        $this->set('exits', array("west" => "fy/nwind3",
                             "east" => "fy/hfenglang1"));
        $this->set('objects', array("fy/npc/showerboy" => 1));
        $this->set('coor/x', 11);
        $this->set('coor/y', 30);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
