<?php
/**
*  洗礼池
*
*/
namespace d\fy;

use std\msg;
use std\room;

class ponder extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '洗礼池');
        $this->set('long', '这里是风云兵马征战回来接受洗礼（salute）的地方，以求洗去杀孽之气。布置得很简单，中间一个水池，池中冒出袅袅水湮。');
        $this->set('exits', array("north" => "fy/ecloud4"));
        $this->set('coor/x', 40);
        $this->set('coor/y', -10);
        $this->set('coor/z', 0);
        $this->set("outdoors", "fengyun");
        
        parent::setup_room();
    }

    public function do_salute($ob, $arg = null)
    {
        $me = $ob->body;
        if ($me->query('sen') < 51) {
            $ob->ssend('你的神不够。');
            return true;
        }
        msg::message('vision', '$N将双手浸入水池中。', $me);
        $me->receive_damage('sen', 50);
        if ($me->query('bellicosity') > 0) {
            $kar = $me->query('kar');
            $me->add('bellicosity', -(rand(0, $kar))); 
            msg::message('vision', '$N身上的杀孽之气似乎轻了。 ', $me);
        }
        return true;
    }
}
