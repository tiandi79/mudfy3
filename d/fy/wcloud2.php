<?php
/**
*  西云大路
*
*/
namespace d\fy;

use std\msg;
use std\room;

class wcloud2 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '西云大路');
        $this->set('long', '也许是快到风云广场的原故，这里的气氛渐渐明朗起来。脚下已不是坎坷不平的黄土路，大块的黑石砌成的大路可容八马并行，路上的行人脚步轻快，神情开朗，大路的南侧是风云城中的知府衙门，大路的北首是风云绎站。');
        $this->set('exits', array("south" => "fy/govern",
                             "north" => "fy/mailst",
                             "east" => "fy/wcloud1",
                             "west" => "fy/wcloud3"));

        $this->set('coor/x', -20);
        $this->set('coor/y', 0);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');

        parent::setup_room();
    }
}
