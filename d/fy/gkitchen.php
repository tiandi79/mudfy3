<?php
/**
*  镖局厨房
*
*/
namespace d\fy;

use std\msg;
use std\room;

class gkitchen extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '镖局厨房');
        $this->set('long', '金狮镖局对伙计们十分款待，不但每月有薪金，而且还包吃住。这里就是伙计们一日三餐的地方。厨房的墙上挂满了锅碗瓢盆，还有一些风干的卤味儿。房中放着一张长台，长台的周围摆着几条长凳。');
        $this->set('exits', array("north" => "fy/goldlion"));
        $this->set('objects', array("fy/npc/goldcook" => 1));
        $this->set('coor/x', 10);
        $this->set('coor/y', 30);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
