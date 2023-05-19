<?php
/**
*  冥府节司
*
*/
namespace d\death;

use std\room;

class jie extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '冥府节司');
        $this->set('long', '自古以来，男女大防，节字难守，多少女子，因种种诱惑，身败名裂，受那地狱分尸之苦。节司两旁尽是贞节女子的画像，画像中簇拥着一位女子端坐案上，正是节司的掌管--绿珠，当年虽身为石崇侍妾，可宁死不随他人，终跳楼而死，节烈之气，名扬千古。在其光芒之中，正受分尸之刑的男男女女，更为丑陋。');
        $this->set('exits', array("northeast" => "death/naihe2"));
        $this->set('objects', array("death/npc/greengirl" => 1));

        $this->set('coor/x', -1030);
        $this->set('coor/y', -30);
        $this->set('coor/z', -100);

        parent::setup_room();
    }
}
