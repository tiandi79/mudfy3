<?php
/**
*  安生棺材店
*
*/
namespace d\fy;

use std\room;

class ansheng extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '安生棺材店');
        $this->set('long', '这里的老板是从南方过来的。官话很差，所以这里的生意并不很好。但阿发好像并不在乎，似乎另有发财之路。他好像很怕光，所以这里一盏灯也没有，从傍晚开始，店里黑漆漆的一片，阿发就睁着一双发亮的眼睛坐在这里望着门外的大街。');
        $this->set('exits', array("north" => "fy/wcloud4"));
        $this->set('objects', array('d/fy/npc/cafen' => 1));
        $this->set('coor/x', -40);
        $this->set('coor/y', -10);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
