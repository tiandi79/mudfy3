<?php
/**
*  南风大街
*
*/
namespace d\fy;

use std\room;

class swind5 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '南风大街');
        $this->set('long', '这里的街道宽敞而干净，汉白玉砌的路面被雨水冲得光明如镜，街道两侧的瓦房高大而宏伟，分明是巨富宅院。双人合抱的杨树十步一株，整齐的排在两边。只听到树上的小鸟时而不时的啾鸣几声，这里到处都散发着安祥宁静的气氛。街道西边是普生堂，东边则是南宫钱庄。');
        $this->set('exits', array("south" => "fy/sgate",
                             "north" => "fy/swind4",
                             "east" => "fy/nanbank",
                             "west" => "fy/pusheng"));

        $this->set('coor/x', 0);
        $this->set('coor/y', -50);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');

        parent::setup_room();
    }
}
