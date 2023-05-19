<?php
/**
*  西云大路
*
*/
namespace d\fy;

use std\msg;
use std\room;

class wcloud3 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '西云大路');
        $this->set('long', '宽宽的黄土路向东西方向伸展，路边的茅屋矮小而破旧，街边的垃圾散发着令人作呕的腐臭，路上的行人面黄肌瘦，被贫困的生活拖得疲惫不堪。偶而有一两个面色红润之人，都掩鼻匆匆而过，生怕沾上一点晦气。南首有一扇木门，上面写道：每夜五十文，北首则是相面大师乙成仙的招牌：生死已卜。');
        $this->set('exits', array("south" => "fy/cheaph",
                             "north" => "fy/futhur",
                             "east" => "fy/wcloud2",
                             "west" => "fy/wcloud4"));

        $this->set('coor/x', -30);
        $this->set('coor/y', 0);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');

        parent::setup_room();
    }
}
