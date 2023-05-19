<?php
/**
*  北风大街
*
*/
namespace d\fy;

use std\room;

class nwind5 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '北风大街');
        $this->set('long', '风街在这里渐渐变窄，街道两旁的店铺群立而又参差不齐。街的东边是一所小小的城隍庙，庙门破旧不堪。门上依稀的用木炭涂着一支手，这只手里似乎抓着十三支短箭。据说这里晚上常有鬼魂的出现。街的西边则是一家包子店。');
        $this->set('exits', array("south" => "fy/nwind4",
                             "north" => "fy/ngate",
                             "east" => "fy/hiretem",
                             "west" => "fy/baozipu"));

        $this->set('coor/x', 0);
        $this->set('coor/y', 50);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');

        parent::setup_room();
    }
}
