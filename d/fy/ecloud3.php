<?php
/**
*  东云大路
*
*/
namespace d\fy;

use std\room;

class ecloud3 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '东云大路');
        $this->set('long', '这里是风云城中三教九流，龙蛇混集之所。不管你是达官贵人，还是贩夫走卒，只要你身上有两钱儿，在这里就会受到热情的招呼。任何你不知道的事，在这里打听一下，都可以知道个八九不离十。整条街上有卖菜的，卖肉的，卖玩具的，卖艺的，卖药的...，应有尽有。');
        $this->set('exits', array("south" => "fy/washroom",
                             "north" => "fy/smithy",
                             "east" => "fy/ecloud4",
                             "west" => "fy/ecloud2"));
        $this->set('objects', array("fy/npc/wanfan" => 1));
        $this->set('coor/x', 30);
        $this->set('coor/y', 0);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');

        parent::setup_room();
    }
}
