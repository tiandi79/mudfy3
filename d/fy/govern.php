<?php
/**
*  风云衙门
*
*/
namespace d\fy;

use std\msg;
use std\room;

class govern extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '风云衙门');
        $this->set('long', '这里是朝廷所设，风云城里的纠纷都可以在这里上状请求处理。大厅南首一张卷檐木案，案上有个小竹桶，里面插着几根有知府官印的竹签。木案后的太师椅上铺着雪绒皮，椅后屏风上红日青云图。上悬金边匾：<br><br>  明察秋毫<br><br>');
        $this->set('exits', array("north" => "fy/wcloud2",
            "east" => "fy/shufang"));
        $this->set('objects', array('d/fy/npc/yayi' => 2,
            'd/fy/npc/yayi2' => 2,
            'd/fy/npc/yayi1' => 2));
        $this->set('coor/x', -21);
        $this->set('coor/y', -10);
        $this->set('coor/z', 0);
        $this->set("NONPC", 1);

        parent::setup_room();
    }
}
