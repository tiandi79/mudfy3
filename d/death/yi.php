<?php
/**
*  冥府义司
*
*/
namespace d\death;

use std\room;

class yi extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '冥府义司');
        $this->set('long', '司内陈设与关庙毫无不同，掌印之人是关二爷，抚须沉思，正与人对弈，当年千里送嫂，过五关斩六将，虽上马金，下马银，不能改其义，反观那不义之徒，有何面目苟全于天地。堂下铡刀数口，专铡不义之人。想起了你以前做过的事，你不由得一身冷汗。');
        $this->set('exits', array("northwest" => "death/naihe2"));
        $this->set('objects', array("death/npc/guan" => 1));

        $this->set('coor/x', -1010);
        $this->set('coor/y', -30);
        $this->set('coor/z', -100);

        parent::setup_room();
    }
}
