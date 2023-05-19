<?php
/**
*  冥府孝司
*
*/
namespace d\death;

use std\room;

class xiao extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '冥府孝司');
        $this->set('long', '进得门来，当先坐着的竟然是位仙子般的女孩儿，正是汉时缇萦，替父就死，虽未死，但孝道天下皆闻，两侧皆是那卧冰取鱼饷母，暖父而自僵的孝子贤孙，殿上一块大匾，上书“孝义传家”，案下无数囚犯，正在受油锅煎熬，都是那不孝之徒。');
        $this->set('exits', array("southwest" => "death/naihe2"));
        $this->set('objects', array("death/npc/suo" => 1));

        $this->set('coor/x', -1010);
        $this->set('coor/y', -10);
        $this->set('coor/z', -100);

        parent::setup_room();
    }
}
