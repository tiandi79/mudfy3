<?php
/**
*  冥府大道
*
*/
namespace d\death;

use std\room;

class naihe2 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '冥府大道');
        $this->set('long', '这里已到冥界的中心，路的两边是冥界四司，掌管人事轮回，名为忠，孝，节，义，彰善惩恶，天理循环，到此报应，但凡来者无不前往一睹，以警自身。');
        $this->set('exits', array("south" => "death/yanluo",
            "north" => "death/naihe",
            "northwest" => "death/zong",
            "southwest" => "death/jie",
            "northeast" => "death/xiao",
            "southeast" => "death/yi"));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -20);
        $this->set('coor/z', -100);

        parent::setup_room();
    }
}
