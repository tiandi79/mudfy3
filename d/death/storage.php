<?php
/**
*  储藏室
*
*/
namespace d\death;

use std\msg;
use std\room;

class storage extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '储藏室');
        $this->set('long', '这是焦都驿存放杂货的地方，可是这里只有南瓜。东面的土墙上似乎有很多人影在晃动。');
        $this->set('exits', array("north" => "d/quicksand/huangyie1"));

        $this->set('objects', array("death/npc/obj/pumpkin" => 10,
            'death/npc/obj/wineskin' => 10));

        $this->set('coor/x', -1000);
        $this->set('coor/y', 0);
        $this->set('coor/z', -90);
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
        $room2 = $OBJECT->get_room('/d/death/ghostinn');
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
