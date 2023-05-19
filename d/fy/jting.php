<?php
/**
*  会客厅
*
*/
namespace d\fy;

use std\room;

class jting extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '会客厅');
        $this->set('long', '大厅布置简单，几张太师椅围着一张八仙桌。房间的两侧是一些小巧玲珑的陈设品。每当风吹入门，门口的风铃发出沙哑的低吟。红砖铺地，上面似乎还有条条暗红色的花
纹。大厅左右各有小门。');
        $this->set('exits', array("east" => "fy/jinqian",
                             "north" => "fy/jhuang",
                            "south" => "fy/jhuang1"));

        $this->set('coor/x', -20);
        $this->set('coor/y', -25);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
