<?php
/**
*  地狱门
*
*/
namespace d\death;

use std\room;

class diyu extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '地狱门');
        $this->set('long', '翻过背阴山，群鬼乱舞，孤魂四散，阴嚎之声，不绝于耳，你不由得发足狂奔，转眼已经来到地狱门，一入此门，便是十八层地狱，无数世间
作恶之人在此关押受刑。');
        $this->set('exits', array("north" => "death/shandao",
            'down' => 'death/diaojin'));

        $this->set('objects', array("death/npc/ghost" => 5));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -100);

        parent::setup_room();
    }
}
