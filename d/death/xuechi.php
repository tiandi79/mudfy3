<?php
/**
*  血池狱
*
*/
namespace d\death;

use std\room;

class xuechi extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '血池狱');
        $this->set('long', '这里关押的都是“脱皮露骨，折臂断筋，也只为谋财害命，屠宰畜生堕千年”的恶徒，手上都沾满了他人的血，故阎王以血还血，将这等人浸泡于血池之中，每日受那血腥熏鼻之苦，日以继夜，痛苦难当。');
        $this->set('exits', array("up" => "death/daoshan",
            'down' => 'death/abi'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -260);

        parent::setup_room();
    }
}
