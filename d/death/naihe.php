<?php
/**
*  冥府大道
*
*/
namespace d\death;

use std\room;

class naihe extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '冥府大道');
        $this->set('long', '愁云惨淡之中一片安静，人来人往亦不少于人间，据说但凡能在此路自行行走之人，都是地府中安分守己的良民，地府规矩森严
更甚人间，十八层地狱管尽天下恶人，所以此路倒还太平，安静。顺路前行便是阎宫。');
        $this->set('exits', array("south" => "death/naihe2",
                             "north" => "death/gate"));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -10);
        $this->set('coor/z', -100);

        parent::setup_room();
    }
}
