<?php
/**
*  山道
*
*/
namespace d\death;

use std\room;

class shandao extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '山道');
        $this->set('long', '两边阴云相夹，东西难辨，黑雾迷空，漫漫黑雾，是鬼祟口中喷出气，“一望高低无影踪，相看左右尽猖亡”说得便是这里了，你战战兢兢的继续前行，心中忐忑不安。');
        $this->set('exits', array("northup" => "death/beiyin",
            'south' => 'death/diyu'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -60);
        $this->set('coor/z', -100);

        parent::setup_room();
    }
}
