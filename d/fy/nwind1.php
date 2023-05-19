<?php
/**
*  北风大街
*
*/
namespace d\fy;

use std\room;

class nwind1 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '北风大街');
        $this->set('long', '风街是风云城最热闹的两条街道之一。街道上人来人往，络绎不绝。街道两旁店铺众多，生意兴隆。叫卖声、喝采声、和女人们的娇笑声，声声入耳。糕点的甜味儿，酒菜的香味儿，和女人身上的花粉味儿，不时的穿鼻入脑，给人以目眩头晕的感觉。大街的东侧是风云城中最贵的酒楼—风云阁，大街的西侧则是警世书局。');
        $this->set('exits', array("south" => "fy/fysquare",
                             "north" => "fy/nwind2",
                             "east" => "fy/fyge",
                             "west" => "fy/jssju"));
        $this->set('objects', array("fy/npc/zhu" => 1));
        $this->set('coor/x', 0);
        $this->set('coor/y', 10);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');

        parent::setup_room();
    }
}
