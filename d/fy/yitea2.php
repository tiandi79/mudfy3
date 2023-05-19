<?php
/**
*  一品居二楼
*
*/
namespace d\fy;

use std\room;

class yitea2 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '一品居二楼');
        $this->set('long', '站在这里，打开小窗就可以看到对面银钩赌坊那闪亮，在风中摇曳的银钩。再往远处看，便是一片梅林。梅林中露出一角小楼，那正是小李飞刀昔日读书学剑的地方。梅林无恙，但仿佛比几年前开的更胜了。');
        $this->set('exits', array("down" => "fy/yitea"));
        $this->set('objects', array("fy/npc/lson" => 1));
        $this->set('coor/x', 10);
        $this->set('coor/y', -30);
        $this->set('coor/z', 10);
        
        parent::setup_room();
    }
}
