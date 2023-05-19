<?php
/**
*  鬼门关
*
*/
namespace d\death;

use std\room;

class gate extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '鬼门关');
        $this->set('long', '猛一惊醒，不觉身在鬼门关，高大的城墙边渭水环绕，阴气森森，几个面目狰狞的牛头，马面手持武器把守城门，勾死人手持铁链正在拖拽着几个人影走了进去．．．．．．．，城门楼上高悬一幅牌匾：鬼门关。');
        $this->set('exits', array("south" => "death/naihe",
                             "east" => "death/aihe2"));
        $this->set('objects', array("death/npc/niutou" => 1,
                                "death/npc/mamian" => 1,
                                "death/npc/panguan" => 1
                            ));
        $this->set('coor/x', -1020);
        $this->set('coor/y', 0);
        $this->set('coor/z', -100);
        $this->set('outdoor', false);
        $this->set('no_fight', 1);
        $this->set('no_magic', 1);
        $this->set('valid_startroom', 1);

        parent::setup_room();
    }
}
