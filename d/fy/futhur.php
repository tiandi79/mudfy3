<?php
/**
*  红屋
*
*/
namespace d\fy;

use std\room;

class futhur extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '红屋');
        $this->set('long', '这是西城区唯一比较像样的建筑，但颜色很怪，一种血色干凝的暗红色。屋里更是鬼气森森。房子无窗，一盏油灯忽明忽暗。以太极八卦图为底的招牌上用篆体刻着四个字“生死已卜”，也是黯淡无光的红色。');
        $this->set('exits', array("south" => "fy/wcloud3"));
        $this->set('objects', array('d/fy/npc/dashi' => 1));
        $this->set('coor/x', -30);
        $this->set('coor/y', 10);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
