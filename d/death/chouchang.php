<?php
/**
*  抽肠狱
*
*/
namespace d\death;

use std\room;

class chouchang extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '抽肠狱');
        $this->set('long', '这里似乎与别处又是不同，没有大刑具，所有的东西就是几把钩子和几把解牛刀，鬼卒熟练的用刀剖开肚子，钩子一钩，便是一声惨叫，听着这声音，头皮发麻的你发誓以后绝不做坏事了，遍地的肠子让人只做呕，但是心中又多了一分向善之心。这里往下便又是一种了。');
        $this->set('exits', array("up" => "death/tuoke",
            'down' => 'death/youguo'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -220);

        parent::setup_room();
    }
}
