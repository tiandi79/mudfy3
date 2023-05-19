<?php
/**
*  孟婆驿
*
*/
namespace d\death;

use std\room;

class mengpo extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '孟婆驿');
        $this->set('long', '一个小小的驿站，小店里很黑，只有东边的窗外有一丝亮光透过发黄的窗纸射入店内。很多黑影在角落里晃动，有些一闪就不见了。');
        $this->set('exits', array('north' => 'death/aihe'));
        $this->set('objects', array("death/npc/mengpo" => 1));
        $this->set('coor/x', -1020);
        $this->set('coor/y', -100);
        $this->set('coor/z', -290);

        parent::setup_room();
    }
}
