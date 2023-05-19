<?php
/**
*  黄衣室
*
*/
namespace d\fy;

use std\room;

class jhuang extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '黄衣室');
        $this->set('long', '黄衣警卫专门负责金钱帮总舵的安全。凡是来人，都要经过他们的检察。这里是他们轮班休息的所在。屋中有几张小床，几张小几。每张床头都有小钩，警卫们都把兵器挂在钩上，一伸手，他们就可以最快的速度拔出自己的兵刃。');        
        $this->set('exits', array("west" => "fy/tang2",
            'north' => 'fy/tang3',
            'east' => 'fy/tang1',
            'south' => 'fy/jting'));
        $this->set('objects', array("fy/npc/huangyi" => 3));
        $this->set('coor/x', -20);
        $this->set('coor/y', -10);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
