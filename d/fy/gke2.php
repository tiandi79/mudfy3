<?php
/**
*  镖局厢房
*
*/
namespace d\fy;

use std\room;

class gke2 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '镖局厢房');
        $this->set('long', '房间里布置很简单，只有一张小床，一个小几，和几张方凳。窗台上放着一个磁杯，杯里插着几枝无名小花。房间虽不大，但是给人整洁舒适的感觉。');        
        $this->set('exits', array("south" => "fy/ginhall"));
        $this->set('objects', array("fy/npc/restingbiao" => 2));
        $this->set('coor/x', 30);
        $this->set('coor/y', 50);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
