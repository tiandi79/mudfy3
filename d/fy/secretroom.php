<?php
/**
*  地下密室
*
*/
namespace d\fy;

use std\msg;
use std\room;

class secretroom extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '地下密室');
        $this->set('long', '这里是一间窄小的密室，你的面前只有一个破旧的小床跟一些乾草。');

        $this->set('objects', array("/obj/money/silver" => 1));
        $this->set('coor/x', 20);
        $this->set('coor/y', 50);
        $this->set('coor/z', -10);
        parent::setup_room();
        $silver = $this->is_carry("silver");
	    $silver->set_amount(rand(0, 1000) + 1000);	
	    $silver->set("name", "镖银");
    }
}
 