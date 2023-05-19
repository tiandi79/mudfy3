<?php
/**
*  酆都狱
*
*/
namespace d\death;

use std\room;

class yandu extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '酆都狱');
        $this->set('long', '这里是“哭哭啼啼，凄凄惨惨，不忠不孝伤天理，佛口蛇心堕此门”，这里关押的囚徒罪名比刚刚的又重了，酆都狱是用来关押的，此类犯人实在太多，所以在此关押，受刑则送到下面的拔舌狱。');
        $this->set('exits', array("up" => "death/huokeng",
            'down' => 'death/bashe'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -140);

        parent::setup_room();
    }
}
