<?php
/**
*  忏悔间
*
*/
namespace d\fy;

use std\room;

class chjian extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '忏悔间');
        $this->set('long', '一间只容一个人的小房间。房间的一面墙上有孔，这里的声音可以很清晰的传到隔壁。房间里只有张小木凳和钉在墙上供人放东西的木板。');
        $this->set('exits', array("south" => "fy/church"));
        $this->set('objects', array("fy/npc/chantou" => 1));
        $this->set('coor/x', 10);
        $this->set('coor/y', -19);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');
        $this->set('no_fight',1);
        $this->set('no_magic',1);
        $this->set('no_npc',1);

        parent::setup_room();
    }
}
