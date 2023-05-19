<?php
/**
*  北风大街
*
*/
namespace d\fy;

use std\room;

class nwind2 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '北风大街');
        $this->set('long', '风街是风云城最热闹的两条街道之一。街道上人来人往，络绎不绝。街道两旁店铺众多，生意兴隆。叫卖声、喝采声、和女人们的娇笑声，声声入耳。糕点的甜味儿，酒菜的香味儿，和女人身上的花粉味儿，不时的穿鼻入脑，给人以目眩头晕的感觉。大街东侧的飘香花店和西侧的倾城胭脂店相映生辉。');
        $this->set('exits', array("south" => "fy/nwind1",
                             "north" => "fy/nwind3",
                             "east" => "fy/pxhdian",
                             "west" => "fy/qcyzdian"));

        $this->set('coor/x', 0);
        $this->set('coor/y', 20);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');

        parent::setup_room();
    }
}
