<?php
/**
*  金狮镖局大厅
*
*/
namespace d\fy;

use std\room;

class ghall extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '金狮镖局大厅');
        $this->set('long', '大红地毯，珍奇古玩，高悬字画，表明这里的主人不但性情豪爽，广交朋友，且非大字不识，目中无人之辈。上首一狮皮交椅，左右各明烛闪烁。一古木书案横于椅前，上面整齐的堆着一卷卷镖局压镖的货票。');
        $this->set('exits', array("west" => "fy/goldlion",
            'north' => 'fy/gmoney',
            'east' => 'fy/ginhall'));
        $this->set('objects', array("fy/npc/gmaster" => 1));
        $this->set('coor/x', 20);
        $this->set('coor/y', 40);
        $this->set('coor/z', 0);
        $this->create_door("north", "铁门", "south", 1);
        parent::setup_room();
    }
}
