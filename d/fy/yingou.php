<?php
/**
*  银钩赌坊
*
*/
namespace d\fy;

use std\room;

class yingou extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '银钩赌坊');
        $this->set('long', '银钩赌坊布置豪华，充满了温暖和欢乐，酒香中混合着上等脂粉的香气，银钱敲击，发出一阵阵清脆悦耳的声音。世间几乎没有任何一种音乐能比得上。银钩赌坊实在是个很奢侈的地方，随时都在为各式各样奢侈的人，准备着各式各样奢侈的享受。');
        $this->set('exits', array("east" => "fy/swind3",
            'west' => 'fy/dating'));
        $this->set('objects', array("fy/npc/xiazi" => 1,
            'fy/npc/daniu' => 1));
        $this->set('coor/x', -10);
        $this->set('coor/y', -30);
        $this->set('coor/z', 0);
        
        parent::setup_room();
    }
}
