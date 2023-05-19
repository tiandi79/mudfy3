<?php
/**
*  棉花坊
*
*/
namespace d\fy;

use std\room;

class mianhua extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '棉花坊');
        $this->set('long', '每当天气渐冷，风云老少都会到这儿来将自己的冬衫，冬被弹一弹，这里的老板娘更善长补衣服，补出来的衣服又牢固而且不难看。');
        $this->set('exits', array("south" => "fy/ecloud4"));
        $this->set('objects', array("fy/npc/mianhua" => 1));
        $this->set('coor/x', 40);
        $this->set('coor/y', 10);
        $this->set('coor/z', 0);
        
        parent::setup_room();
    }
}
