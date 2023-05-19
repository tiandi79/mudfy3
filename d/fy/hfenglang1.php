<?php
/**
*  长廊
*
*/
namespace d\fy;

use std\msg;
use std\room;

class hfenglang1 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '长廊');
        $this->set('long', '这里是给到这儿的小姐们更衣入浴的，地上是五光十色的彩带和香味扑鼻的花瓣,昂贵的衣裳满地都是，透过蒙蒙水雾，你可以看到白腻的身躯，修长的大腿，坚挺的胸膛，和乌黑的长发。。。。。。');
        $this->set('exits', array("west" => "fy/hfeng",
                             "north" => "fy/hfenglang2"));

        $this->set('coor/x', 21);
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

        if ($dir == 'north' && $me->query('gender') != '女性') {
            $me->get_conn()->ssend('这是女人浴室，你冲进去作什么？');
            return false;
        }
        return true;
    }
}
