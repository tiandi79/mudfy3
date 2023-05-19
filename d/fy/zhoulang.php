<?php
/**
*  石级甬道
*
*/
namespace d\fy;

use std\room;

class zhoulang extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '石级甬道');
        $this->set('long', '暗门后面十来级石阶，往下延伸成条甬道，甬道里燃着灯，灯火下又有一道门。');
        $this->set('exits', array("north" => "fy/secret",
            'east' => 'pianting'));

        $this->set('coor/x', -30);
        $this->set('coor/y', -20);
        $this->set('coor/z', -10);
        $this->create_door("north", "精铁门", "south", 1);
        parent::setup_room();
    }
}
