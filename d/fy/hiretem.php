<?php
/**
*  城隍庙
*
*/
namespace d\fy;

use std\msg;
use std\room;

class hiretem extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '城隍庙');
        $this->set('long', '阴暗潮湿，破旧不堪，每当狂风吹过，整座庙都在摇晃，似乎马上就会倒塌下来。一支残烛在风中摇曳，忽明忽暗，鬼气森森。整个庙里布满灰尘，只有角落里的一个暗红色的神龛（ｋａｎ）一尘不染。');
        $this->set('exits', array("west" => "fy/nwind5"));

        $this->set('coor/x', 5);
        $this->set('coor/y', 50);
        $this->set('coor/z', 0);

        parent::setup_room();
    }

    public function do_look($ob, $arg)
    {
        if ($arg == null || ($arg != 'kan' && $arg != '神龛'))
            return false;

        $ob->ssend('这个神龛开口很窄，正好可扔下一张纸(throw)。');
        return true;
    }

    public function do_throw($ob, $arg)
    {
        $ob->ssend(OPENSOON);
        return true;
        
        if ($arg == null) {
            $ob->ssend('你要放什么入神龛？');
            return true;
        }

        if ($arg != 'youzhi') {
            $ob->ssend('你不可以把' . $arg . '放入神龛。');
            return true;
        }        
    }
}
