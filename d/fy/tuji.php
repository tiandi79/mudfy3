<?php
/**
*  屠记肉铺
*
*/
namespace d\fy;

use std\room;

class tuji extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '屠记肉铺');
        $this->set('long', '脏稀稀的木板上放着几块颜色灰暗，不堪入目的生肉。一堆绿头苍蝇忙忙碌碌的飞起飞落。几个生了锈的铁勾上挂着半风干了的羊头，猪头，和牛头。柜台的左角儿放着几个木匣，匣中放着些煮熟了的杂碎和排骨。');
        $this->set('exits', array("south" => "fy/wcloud5"));
        $this->set('objects', array('d/fy/npc/butcher' => 1));
        $this->set('coor/x', -50);
        $this->set('coor/y', 10);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
