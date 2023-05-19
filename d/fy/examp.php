<?php
/**
*  考场
*
*/
namespace d\fy;

use std\msg;
use std\room;

class examp extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '考场');
        $this->set('long', '凡是有志于宦途的风云年青人都要在这里通过第一次考试。文武双全的前三名会被送入京都再试。每到一年一度的考季，这里就会人山人海，看热闹的比参考的还多。风云的老一辈大多是望子成龙，所以风云城每年都是人才辈出。');
        $this->set('exits', array("north" => "fy/wcloud1"));
        $this->set('objects', array('fy/npc/kaoguan' => 1,
            'fy/npc/student' => 3));
        $this->set('coor/x', -10);
        $this->set('coor/y', -1);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
