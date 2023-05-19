<?php
/**
*  金狮镖局大院
*
*/
namespace d\fy;

use std\room;

class goldlion extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '金狮镖局大院');
        $this->set('long', '镖局大院里黑石铺地，大院右边零乱的放着一些大小不依的石锁，想必是镖局中的趟子手用来练臂力的。左侧则是碗口粗细一人多高的梅花桩。听说总镖头查猛原本是少林俗家弟子，后得高人指点，在轻功和掌法上都有颇深的造诣。');
        $this->set('exits', array("east" => "fy/ghall",
            'west' => 'fy/nwind4',
            'north' => 'fy/gcang',
            'south' => 'fy/gkitchen'));
        $this->set('objects', array("fy/npc/biaoshi" => 1,
            'fy/npc/biaoshi1' => 1));
        $this->set('coor/x', 10);
        $this->set('coor/y', 40);
        $this->set('coor/z', 0);
        $this->set("outdoors", "fengyun");

        parent::setup_room();
    }
}
