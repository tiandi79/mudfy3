<?php
/**
*  风云书房
*
*/
namespace d\fy;

use std\room;

class fysf extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '风云书房');
        $this->set('long', '这间书房是李探花偶而回来小息时读书所用。屋子布置的精致富丽，当中一张青玉案，案上两只白玉瓶，瓶里插着几十枝茶花。玉瓶旁铺着几张信筏，放着些笔墨砚石，还有个斗大的玉钵，想是用来洗笔的。');
        $this->set('exits', array("west" => "fy/fyyage"));
        $this->set('objects', array("fy/npc/bookgirl" => 1,
            'fy/obj/vase' => 1,
            'fy/obj/flower' => 1));

        $this->set('coor/x', 10);
        $this->set('coor/y', 10);
        $this->set('coor/z', 20);
        
        parent::setup_room();
    }
}
