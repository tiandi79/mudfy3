<?php
/**
*  走廊
*
*/
namespace d\fy;

use std\msg;
use std\room;

class jlonglang2 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '走廊');
        $this->set('long', '一人多高，只容两人并行的檀香木走廊，廊中的两侧陈列着一些奇花异草。滚滚热气从走廊的一头冒出，将檀木地板打得又湿又滑，你几乎要扶着栏杆才不会滑倒。');
        $this->set('exits', array("south" => "fy/jlonglang1",
                             "west" => "fy/jlonglang3"));

        $this->set('coor/x', -20);
        $this->set('coor/y', 40);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
