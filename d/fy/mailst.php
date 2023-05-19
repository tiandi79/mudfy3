<?php
/**
*  风云绎站
*
*/
namespace d\fy;

use std\msg;
use std\room;

class mailst extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '风云绎站');
        $this->set('long', '每天快马三匹，早午晚各传递书信三次。风云城的官府衙役和普通百姓都可以在这儿免费和外地书信来往。不管你的书信要寄到那里，只要放到这里，三天之内绝对可以送到。');
        $this->set('exits', array("south" => "fy/wcloud2"));
        $this->set('objects', array('fy/npc/officer' => 1));
        $this->set('coor/x', -20);
        $this->set('coor/y', 10);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
