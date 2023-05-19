<?php
/**
*  冥府忠司
*
*/
namespace d\death;

use std\room;

class zong extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '冥府忠司');
        $this->set('long', '进得忠司，便见当面一金盔银甲的将军端坐椅上，两侧数位纶巾文士，长须飘飘，仙风道骨。');
        $this->set('exits', array("southeast" => "death/naihe2"));
        $this->set('objects', array("death/npc/yuefei" => 1));

        $this->set('coor/x', -1030);
        $this->set('coor/y', -10);
        $this->set('coor/z', -100);

        parent::setup_room();
    }
}
