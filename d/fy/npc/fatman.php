<?php
/**
*   fatman
*
*/
namespace d\fy\npc;

use std\msg;
use std\vendor;

class fatman extends vendor
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '大胖子');
        $this->set('id', 'fatman');
        $this->set('age', 40);
        $this->set('gender', '男性');
        $this->set('long', '一个白白胖胖的矮胖子．');
        $this->set('combat_exp', 5);
        $this->set("attitude", "friendly");
        $this->set("rank_info/respect", "胖哥");
        $this->set("chat_chance", 2);
        $this->set("chat_msg", array('大胖子指着你讥笑道：你．．你比我还胖还矮．．',
            '大胖子哼道：月圆之夜，紫禁之巅，叶城主赢定了．．'));
        $this->equip_object('/obj/obj/cloth');

        $this->set("vendor_goods", array("d/fy/npc/obj/dogmed" => 10));
    }
}
