<?php
/**
*  南风大街
*
*/
namespace d\fy;

use std\room;

class swind4 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '南风大街');
        $this->set('long', '这里的街道宽敞而干净，汉白玉砌的路面被雨水冲得光明如镜，街道两侧的瓦房高大而宏伟，分明是巨富宅院。双人合抱的杨树十步一株，整齐的排在两边。西边的千金楼白天门可箩雀，但是到了晚上却是热闹非凡。千金楼为了方便客人，又在南风大街的对面开了一座千银当铺。');
        $this->set('exits', array("south" => "fy/swind5",
                             "north" => "fy/swind3",
                             "east" => "fy/qianyin",
                             "west" => "/d/qianjin/qianjin"));

        $this->set('coor/x', 0);
        $this->set('coor/y', -40);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');

        parent::setup_room();
    }
}
