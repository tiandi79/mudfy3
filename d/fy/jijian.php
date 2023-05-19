<?php
/**
*  祭剑亭
*
*/
namespace d\fy;

use std\room;

class jijian extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '祭剑亭');
        $this->set('long', '风云老少大多认为祭剑是取得比武胜利的必要条件之一。每逢年一度的风云城大赛，凡是参赛的人都会到这儿来祭一次兵刃，以求好运。');
        $this->set('exits', array("north" => "fy/ecloud2"));
        $this->set('objects', array("fy/npc/wangfuren" => 1));
        $this->set('coor/x', 20);
        $this->set('coor/y', -10);
        $this->set('coor/z', 0);
        
        parent::setup_room();
    }
}
