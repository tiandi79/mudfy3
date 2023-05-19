<?php
/**
*  平安道
*
*/
namespace d\death;

use std\room;

class pingan extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '平安道');
        $this->set('long', '这里已经是地府最后的道路了，因为此地多是投生的人必经之路，所以十分安静，因为如果稍有喧哗，便会再呆上十年。由此望去，远远的一
座桥，十分的雄伟。');
        $this->set('exits', array("south" => "death/aihe",
            'north' => 'death/wangsi'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -80);
        $this->set('coor/z', -290);

        parent::setup_room();
    }
}
