<?php
/**
*  普生堂
*
*/
namespace d\fy;

use std\room;

class pusheng extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '普生堂');
        $this->set('long', '普生堂本是一云游高僧路经风云城逗留时所设，高僧童心未泯，有感此地风土人情，一留就是三年。亲授一弟子。高僧慧眼识珠，此弟子乃人中之龙，不到三年已将僧人医术尽学。堂中悬匾一块：<br> 妙手回春');
        $this->set('exits', array("east" => "fy/swind5",
            'north' => 'fy/yangsheng'));
        $this->set('objects', array('d/fy/npc/hosowner' => 1));
        $this->set('coor/x', -10);
        $this->set('coor/y', -50);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
