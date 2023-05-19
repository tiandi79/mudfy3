<?php
/**
*  秘室
*
*/
namespace d\fy;

use std\room;

class secret extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '秘室');
        $this->set('long', '屋子并不大，有一张床，一张桌子。屋子里根本没有窗，四面的墙壁竟赫然全都是好几寸厚的铁板。桌子上还摆着一个红木盒子和一些酒菜，酒菜居然全部原封不动。');
        $this->set('exits', array("south" => "fy/zhoulang"));
        $this->set('objects', array('fy/npc/blue' => 1,
            'fy/npc/fangyuxiang' => 1));
        $this->set('coor/x', -30);
        $this->set('coor/y', -10);
        $this->set('coor/z', -10);
        $this->create_door("south", "精铁门", "north", 1);
        parent::setup_room();
    }
}
