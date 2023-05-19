<?php
/**
*  焦都驿
*
*/
namespace d\death;

use std\msg;
use std\room;

class ghostinn extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '焦都驿');
        $this->set('long', '这个驿站十分的简陋，所以生意也不是很好。这里唯一的特色是南瓜。西面的土墙上似乎有很多人影在晃动。');
        $this->set('exits', array("north" => "d/quicksand/huangyie1"));

        $this->set('objects', array("death/npc/ghost" => 5,
            'death/npc/waiter' => 1));

        $this->set('coor/x', -1000);
        $this->set('coor/y', 0);
        $this->set('coor/z', -100);
        $this->set('NONPC', 1);

        parent::setup_room();
    }

    public function do_look($ob, $arg)
    {
        if (null == $arg || ($arg != '土墙' && $arg != 'wall'))
            return false;

        $ob->ssend('一道又破又脏的泥墙，你似乎可以越（ｄａｓｈ）过去。');
        return true;
    }

    public function do_dash($ob, $arg)
    {
        $me = $ob->body;
        global $OBJECT;
        $room1 = $OBJECT->get_room('/d/death/aihe2');
        $room2 = $OBJECT->get_room('/d/death/storage');
        msg::message('vision', '$N往土墙上一越就不见了。', $me);
        if ($me->query_temp('can_pass_wall') != null && $me->query_temp('can_pass_wall') > time()) {
            $me->move($room1);
		    $me->del_temp('can_pass_wall');
        } else {
            $me->move($room2);
        }
        return true;
    }
}
