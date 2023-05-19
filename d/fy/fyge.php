<?php
/**
*  风云阁
*
*/
namespace d\fy;

use std\room;

class fyge extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '风云阁');
        $this->set('long', '风云阁的主人就是当今天下侠名鼎鼎的小李飞刀。李探花长年行侠在外，但还是有很多客人慕名来到此阁，以求一面之缘。阁中大红波斯地毯铺地，富丽堂煌。朱红的大门两侧各挂一幅石刻的对联儿：<br><br>一门七进士，<br>父子三探花。<br><br>');
        $this->set('exits', array("west" => "fy/nwind1",
            'up' => 'fy/fyyage'));
        $this->set('objects', array("fy/npc/fywaiter" => 1));

        $this->set('coor/x', 10);
        $this->set('coor/y', 10);
        $this->set('coor/z', 0);
        $this->set('valid_startroom', 1);
        
        parent::setup_room();
    }
}
