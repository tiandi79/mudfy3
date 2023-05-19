<?php
/**
*  天主教堂
*
*/
namespace d\fy;

use std\room;

class church extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '天主教堂');
        $this->set('long', '这里的建筑别具一格，房顶特别高，成拱形，上面还有个巨大的十字架。房顶上又有满幅的浮雕。雕的是一些金发碧眼，背生翅膀的小天使。教堂正中的十字架上钉
着一个全身是血，长发披面的塑像。');
        $this->set('exits', array("north" => "fy/chjian",
                             "west" => "fy/swind2"));
        $this->set('objects', array("fy/npc/priest" => 1));
        $this->set('coor/x', 10);
        $this->set('coor/y', -20);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');
        $this->set('no_fight', 1);
        $this->set('no_magic', 1);
        $this->set('no_npc', 1);

        parent::setup_room();
    }
}
