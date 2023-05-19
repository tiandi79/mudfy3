<?php
/**
*  西云大路
*
*/
namespace d\fy;

use std\msg;
use std\room;

class wcloud4 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '西云大路');
        $this->set('long', '宽宽的黄土路向东西方向伸展，路边的茅屋矮小而破旧，街边的垃圾散发着令人作呕的腐臭，路上的行人面黄肌瘦，被贫困的生活拖得疲惫不堪。偶而有一两个面色红润之人，都掩鼻匆匆而过，生怕沾上一点晦气。大路南侧的安生棺材店中迎门放着几口薄皮木棺，大路北面的阿发木器店中黑漆漆一片，从这里根本看不到里面有什么。');
        $this->set('exits', array("south" => "fy/ansheng",
                             "north" => "fy/afa",
                             "east" => "fy/wcloud3",
                             "west" => "fy/wcloud5"));
        $this->set('objects', array('d/fy/npc/beggar' => 3));

        $this->set('coor/x', -40);
        $this->set('coor/y', 0);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');

        parent::setup_room();
    }
}
