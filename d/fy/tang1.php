<?php
/**
*  恩怨堂
*
*/
namespace d\fy;

use std\msg;
use std\room;

class tang1 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '恩怨堂');
        $this->set('long', '堂正中檀木香案，案上燃着几炷香，整间屋檀香袅袅。凡是入此堂的人，都愿把以往恩怨一笔勾消。如果你有愧你的所作所为，想从新作人，忘记已往的恩恩怨怨，只需在这里跪下（ＫＮＥＥＬ）。');        
        $this->set('exits', array("west" => "fy/jhuang"));
        $this->set("no_fight", 1);
	    $this->set("no_magic", 1);
	    $this->set("NONPC", 1);
        $this->set('coor/x', -10);
        $this->set('coor/y', -10);
        $this->set('coor/z', 0);

        parent::setup_room();
    }

    public function do_kneel($ob, $arg = null)
    {
        $me = $ob->body;
        $me->remove_all_killer();
        msg::message('vision', '$N跪倒在地，决定忘记以前所有的仇家。', $me);
        return true;
    }
}
