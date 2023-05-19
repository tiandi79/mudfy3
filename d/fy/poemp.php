<?php
/**
*  探花诗台
*
*/
namespace d\fy;

use std\msg;
use std\room;

class poemp extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '探花诗台');
        $this->set('long', '风云中的老老少少大都有吟诗对词的雅好。只要稍有灵感，就会带着笔墨到这里来酝酿，等到灵光乍现那霎那，奋笔急书，以求千古名句。诗台正中朱笔入木狂草：');
        $this->set('exits', array("south" => "fy/wcloud1"));
        $this->set('objects', array('/obj/board/poemp_b' => 1,
            'fy/npc/yaren' => 1,
            'fy/npc/prince' => 1));
        $this->set('coor/x', -10);
        $this->set('coor/y', 1);
        $this->set('coor/z', 0);
        $this->set('no_death_penalty', 1);

        parent::setup_room();
    }
}
