<?php
/**
*  风云天骄门
*
*/
namespace d\fy;

use std\room;

class hall extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '风云天骄门');
        $this->set('long', '这是一座古老而神圣的大理石门，大约建于百年前。门上斑斑点点，风化不堪。传说中是玉皇大帝临凡佳奖天下儿女英雄的地方，凡是被佳
奖的英雄都成为不死之身。');
        $this->set('exits', array("south" => "fy/ecloud5"));

        $this->set('coor/x', 50);
        $this->set('coor/y', 10);
        $this->set('coor/z', 0);
        
        parent::setup_room();
    }
}
