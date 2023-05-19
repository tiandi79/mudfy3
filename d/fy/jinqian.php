<?php
/**
*  金钱帮大院
*
*/
namespace d\fy;

use std\room;

class jinqian extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '金钱帮大院');
        $this->set('long', '大院里冷冷清清，也静的出奇。院中的老树在地上拖出长长的影子。偶尔几声鸟叫，打破死沈沈的寂静。微风吹过，树叶舞动，发出“沙沙”的声音。黄沙的地面铺满枯黄的落叶。几条黄色的人影在阴暗的角落里忽隐忽现。');
        $this->set('exits', array("east" => "fy/swind2",
                             "west" => "fy/jting"));

        $this->set('coor/x', -10);
        $this->set('coor/y', -20);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
