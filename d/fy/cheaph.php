<?php
/**
*  土嫖馆
*
*/
namespace d\fy;

use std\msg;
use std\room;

class cheaph extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '土嫖馆');
        $this->set('long', '一间简陋的，用泥坯砌起来的低矮小房。东面的墙上有条裂缝，从右上角一直裂到左边的墙角里。西边有一张和泥屋连为一体的土炕。炕下有灶，冬天可以生火取暖，炕头挂着厚布蚊帐，帐上贴纸一张：价格最平，男女老少皆宜，恕不找钱。');
        $this->set('exits', array("north" => "fy/wcloud3"));
        $this->set('objects', array('d/fy/npc/chick' => 1));
        $this->set('coor/x', -30);
        $this->set('coor/y', -9);
        $this->set('coor/z', 0);
        $this->set("no_preach", 1);

        parent::setup_room();
    }
}
