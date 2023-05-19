<?php
/**
*  水牢
*
*/
namespace d\fy;

use std\msg;
use std\room;

class jsecret extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '水牢');
        $this->set('long', '肮脏恶臭的污水齐胸深，污水中钉着几根铁桩，桩上有精钢环，想必是来绑压犯人的。偶尔几个水泡冒上水面，混杂着血沫和已泡得发白发臭的断肢。还有几个桩上用生锈的铁链绑着几个面目狰狞的骷髅。一堆白白胖胖的蛆在欢快的爬进爬出。');        
        $this->set('exits', array("up" => "fy/tang3"));
        $this->set('objects', array("fy/npc/xongyang" => 1));
        $this->set('coor/x', -20);
        $this->set('coor/y', 0);
        $this->set('coor/z', -10);

        parent::setup_room();
    }
}
