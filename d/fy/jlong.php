<?php
/**
*  浸龙前厅
*
*/
namespace d\fy;

use std\room;

class jlong extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '浸龙前厅');
        $this->set('long', '地板是上好的檀香木，光滑而略带潮湿。左手边是一个柜台，后面有个架子,上面挂满了白毛巾。几个如花似玉的小丫环正在忙碌，望向窗外，一个巨大的青铜缸架在烈火上，丫环们正在慢慢的加入清泉水。');
        $this->set('exits', array("east" => "fy/nwind3",
                             "west" => "fy/jlonglang1"));
        $this->set('objects', array("fy/npc/showergirl" => 2));
        $this->set('coor/x', -10);
        $this->set('coor/y', 30);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
