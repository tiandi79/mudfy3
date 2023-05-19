<?php
/**
*  薛记包子
*
*/
namespace d\fy;

use std\msg;
use std\room;

class baozipu extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '薛记包子');
        $this->set('long', '店里布置简陋，只有几张方桌和几张长凳。桌面油漆剥落，再也看不出它原来的颜色。肮脏而残破的碗筷零乱的散落在桌面上。墙角里还有几支脏稀稀的筷子，上面已结满了蜘蛛网。几只乌蝇在盲目的飞来飞去。。。');
        $this->set('exits', array("east" => "fy/nwind5"));
        $this->set('objects', array("fy/npc/lifeseller" => 1));
        $this->set('coor/x', -10);
        $this->set('coor/y', 50);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
