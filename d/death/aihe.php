<?php
/**
*  奈河桥
*
*/
namespace d\death;

use std\room;

class aihe extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '奈河桥');
        $this->set('long', '许多人只知道奈何桥，却不知道奈河桥，其实奈河桥名来自奈河，奈河贯穿地府，内有冤魂，过枉死城后则只有金色鲤鱼，桥上通体翡翠，巧
夺天工，桥身雕刻得极为精细，不愧为鬼神妙手。由此过去便是地府最后一站，孟婆驿。');
        $this->set('exits', array("south" => "death/mengpo",
            'north' => 'death/pingan'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -90);
        $this->set('coor/z', -290);

        parent::setup_room();
    }
}
