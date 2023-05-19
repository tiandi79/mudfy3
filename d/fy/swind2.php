<?php
/**
*  南风大街
*
*/
namespace d\fy;

use std\room;

class swind2 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '南风大街');
        $this->set('long', '这里的街道宽敞而干净，汉白玉砌的路面被雨水冲得光明如镜，街道两侧的瓦房高大而宏伟，分明是巨富宅院。双人合抱的杨树十步一株，整齐的排在两边。大街西面一对千斤巨鼎，悬挂在朱门两旁。这里就是金钱帮的总舵。大街东面巨宅上有一高高的十字架，一些金发碧眼，身披黑袍的人不时的出出入入。');
        $this->set('exits', array("south" => "fy/swind3",
                             "north" => "fy/swind1",
                             "east" => "fy/church",
                             "west" => "fy/jinqian"));

        $this->set('coor/x', 0);
        $this->set('coor/y', -20);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');

        parent::setup_room();
    }
}
