<?php
/**
*  背阴山
*
*/
namespace d\death;

use std\room;

class beiyin extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '背阴山');
        $this->set('long', '地藏殿后门出来，忽然阴风刺骨，原来到了背阴山，背阴山乃地府最险恶的地方，漫山遍野皆是孤魂野鬼，形多凹凸，山势险峻，峻如蜀岭，高似庐岩，你不由得硬着头皮往前走。');
        $this->set('exits', array("northdown" => "death/dizang",
            'southdown' => 'death/shandao'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -50);
        $this->set('coor/z', -90);

        parent::setup_room();
    }
}
