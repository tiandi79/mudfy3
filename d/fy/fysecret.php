<?php
/**
*  风云雅阁密室
*
*/
namespace d\fy;

use std\room;

class fysecret extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '风云雅阁密室');
        $this->set('long', '密室虽小，布置得很精致。四周陈列很是简单，只是一个个巴掌大的木像。每个木像似乎都是同一个女人的样子，但是木像的面部全是空白，根本看不出木像是谁。房间的左侧放着一张小床，床上躺着一个不断咳嗖，面目苍白的中年人。');
        $this->set('exits', array("south" => "fy/fyyage"));
        $this->set('objects', array("fy/npc/lixunhuan" => 1,
            'fy/obj/muou' => 1));

        $this->set('coor/x', 10);
        $this->set('coor/y', 20);
        $this->set('coor/z', 10);
        $this->set("no_magic",1);
	    $this->set("NONPC",1);
        
        parent::setup_room();
    }
}
