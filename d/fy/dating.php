<?php
/**
*  银钩赌坊大厅
*
*/
namespace d\fy;

use std\room;

class dating extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '银钩赌坊大厅');
        $this->set('long', '一眼看过去，这大厅里真是金碧辉煌，堂皇富丽，连烛台都是纯银的，在这种地方输了千儿八百两金子，没人会觉得冤枉。大厅里摆满了大大小小的赌桌，只要能说出名堂的赌具，这里都有。有匾（ｓｉｇｎ）一块。');
        $this->set('exits', array("east" => "fy/yingou",
            'north' => 'fy/pianting'));
        $this->set('objects', array("fy/npc/huang" => 1,
            'fy/npc/obj/stealingbook' => 1));
        $this->set('coor/x', -20);
        $this->set('coor/y', -30);
        $this->set('coor/z', 0);
        $this->set("NONPC", 1);
        
        parent::setup_room();
    }

    public function do_look($ob, $arg)
    {
        if (null == $arg || $arg != 'sign')
            return false;

        $ob->ssend('骰子的赌法：<br>ｂｅｔ　＜种类＞　＜银量＞<br>种类：　０，１，２，３到１８<br>０：　		赌小	（３－１０）	一赔一<br>１：  		赌大	（１１－１８）	一赔一<br>２：　		赌围骰	（三粒骰子同点）一赔三十六<br>３－１８	赌单点  		一赔八<br><br>例子：<br>
ｂｅｔ　０　５０<br>赌五十两在小上');
        return true;
    }
}
