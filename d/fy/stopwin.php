<?php
/**
*  镇风兵器铺
*
*/
namespace d\fy;

use std\room;

class stopwin extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '镇风兵器铺');
        $this->set('long', '此铺的大老板乃是金狮镖局的总镖头，大掌柜则是大镖头诸葛雷。十八般外门兵器，这里应有尽有。四周的墙上还陈列着百晓生兵器谱上赫赫有名的人物赖以成名的奇门兵器。');
        $this->set('exits', array("east" => "fy/nwind4"));
        $this->set('objects', array("fy/npc/weaponer" => 1));
        $this->set('coor/x', -10);
        $this->set('coor/y', 40);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
