<?php
/**
*  玉龙珠宝店
*
*/
namespace d\fy;

use std\room;

class yuljade extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '玉龙珠宝店');
        $this->set('long', '珠宝店的正中是块千年古玉雕成的祥龙，玉龙活灵活现，穿梭于祥云之中。龙嘴中含玉球，玉球有拳头大小，翠绿欲滴。龙眼半睁半闭。四周的墙上挂满了各种金玉制品和各种护身吉祥玉器。');
        $this->set('exits', array("east" => "fy/swind1"));
        $this->set('objects', array("fy/npc/jadeowner" => 1));
        $this->set('coor/x', -1);
        $this->set('coor/y', -10);
        $this->set('coor/z', 0);
        
        parent::setup_room();
    }
}
