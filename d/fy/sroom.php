<?php
/**
*  堂屋
*
*/
namespace d\fy;

use std\room;

class sroom extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '堂屋');
        $this->set('long', '屋子里潮湿而阴暗，屋子并不十分窄小，但只有一桌，一床，一凳．更显得四壁箫然，空洞寂寞．也衬得那一盏孤灯更昏黄暗淡．壁上的积尘未除，屋面上还结着蛛网．');
        $this->set('exits', array("south" => "fy/stone2"));
        $this->set('objects', array('fy/npc/masterye' => 1));
        $this->set('coor/x', 9);
        $this->set('coor/y', 30);
        $this->set('coor/z', 0);
        $this->set('valid_startroom', 1);

        $this->create_door("south", "窄门", "north", 1);
        parent::setup_room();
    }
}
