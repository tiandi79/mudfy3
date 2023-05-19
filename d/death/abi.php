<?php
/**
*  阿鼻狱
*
*/
namespace d\death;

use std\room;

class abi extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '阿鼻狱');
        $this->set('long', '又名穿鼻狱，来到这里的人下世绝无转生为人的可能，这里的人都象牛一样，鼻孔被穿，无数牛头，马面牵之来回行走，不时以铜锤击身，钢
鞭敲打，使其时刻警醒。再下面便是最后一层秤杆狱。');
        $this->set('exits', array("up" => "death/xuechi",
            'down' => 'death/banggan'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -270);

        parent::setup_room();
    }
}
