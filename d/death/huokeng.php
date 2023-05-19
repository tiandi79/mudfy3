<?php
/**
*  火坑狱
*
*/
namespace d\death;

use std\room;

class huokeng extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '火坑狱');
        $this->set('long', '一进来，扑面的热气几乎让你昏了过去，火海之中，几个犯人正在来回穿梭，每过一次，浑身骨肉俱成焦炭，然后被鬼卒浇上神水后恢复
原样，又拿着铁棒赶进火里。你不由得心胆俱焚，暗自庆幸生前未曾做下什么罪业。由此向下是酆都狱。');
        $this->set('exits', array("up" => "death/yiuwang",
            'down' => 'death/yandu'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -130);

        parent::setup_room();
    }
}
