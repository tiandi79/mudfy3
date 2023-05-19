<?php
/**
*  枉死城
*
*/
namespace d\death;

use std\room;

class wangsi extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '枉死城');
        $this->set('long', '远远看去便觉得怨气冲天，到这里的都是枉死的冤魂，他们死于历代战争，因尸骨无人收埋，家人离散，虽死但怨气不灭，逐渐聚集在一起，
阎君因为怜其可怜，也不加刑罚，只是管束在这枉死城中，但有好心人在人间摆开水陆道场，超度亡魂，便有部分冤魂可以安息，可惜历代战祸不绝，枉死城中的冤魂竟然越来越多。过了枉死城，便是平安道了。');
        $this->set('exits', array("south" => "death/pingan"));

        $this->set('objects', array("death/npc/ghost" => 5));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -290);

        parent::setup_room();
    }
}
