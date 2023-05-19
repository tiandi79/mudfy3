<?php
/**
*  凤求凰客栈
*
*/
namespace d\fy;

use std\room;

class fqkhotel extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '凤求凰客栈');
        $this->set('long', '前厅挂着一幅龙凤双飞的巨画。当门挂着对鸳鸯球。球上系着几个小小的黄铜风铃。微风掠过，风铃发出清脆悦耳的叮咚声。大门两侧挂着斗大的大红灯笼，上各书凤凰两字。朱门上横批一个“求”字。');
        $this->set('exits', array("west" => "fy/swind1"));
        $this->set('objects', array("fy/npc/waiter" => 1));
        $this->set('coor/x', 10);
        $this->set('coor/y', -10);
        $this->set('coor/z', 0);
        $this->set('valid_startroom', 1);
        
        parent::setup_room();
    }
}
