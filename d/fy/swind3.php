<?php
/**
*  南风大街
*
*/
namespace d\fy;

use std\room;

class swind3 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '南风大街');
        $this->set('long', '这里的街道宽敞而干净，汉白玉砌的路面被雨水冲得光明如镜，街道两侧的瓦房高大而宏伟，分明是巨富宅院。双人合抱的杨树十步一株，整齐的排在两边。一个闪亮的银钩挂在大街西面一座巨宅的飞檐下，象征着风云城中最豪赌的银钩赌坊。银钩赌坊的对面则是一品居茶座。');
        $this->set('exits', array("south" => "fy/swind4",
                             "north" => "fy/swind2",
                             "east" => "fy/yitea",
                             "west" => "fy/yingou"));

        $this->set('coor/x', 0);
        $this->set('coor/y', -30);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');

        parent::setup_room();
    }
}
