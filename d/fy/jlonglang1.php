<?php
/**
*  走廊
*
*/
namespace d\fy;

use std\msg;
use std\room;

class jlonglang1 extends room
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
        $this->set('exits', array("east" => "fy/jlong",
                             "north" => "fy/jlonglang2"));

        $this->set('coor/x', -20);
        $this->set('coor/y', 30);
        $this->set('coor/z', 0);

        parent::setup_room();
    }

    public function valid_leave($me, $dir)
    {
        if (rand(0, $me->query('kar')) < 2) {
            msg::message('vision', '$N脚下一个不稳，四脚朝天地摔在地上。', $me);
            $me->unconcious();
            return false;
        }

        if ($dir == 'north' && $me->query('gender') != '男性') {
            $me->get_conn()->ssend('这是男人浴室，你冲进去作什么？');
            return false;
        }
        return true;
    }
}
