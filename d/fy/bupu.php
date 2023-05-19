<?php
/**
*  风云布铺
*
*/
namespace d\fy;

use std\room;

class bupu extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '风云布铺');
        $this->set('long', '布铺里摆满了绫罗绸缎，这里专门订作，裁剪，改装各种鞋，帽，衫．这里做的衣服不但款式新颖，而且经久耐用．风云老少们穿的大部份都是这里出的．门口有一个大木牌（ｓｉｇｎ）。');
        $this->set('exits', array("south" => "fy/ecloud2"));
        $this->set('objects', array("fy/npc/caifeng" => 1));
        $this->set('coor/x', 20);
        $this->set('coor/y', 10);
        $this->set('coor/z', 0);
        
        parent::setup_room();
    }

    public function do_look($ob, $arg)
    {
        if (null == $arg || $arg != 'sign')
            return false;

        $ob->ssend('这里是布铺，目前我们可订作（ding）：<br>帽子（hat），外衣（cloth），<br>腰带（belt），布鞋（shoes）．<br>每件一两黄金．<br>例子：ding cloth 团金黄龙袍 robe bu<br>布铺就会用你带来的布料帮你作一件外衣叫＂团金黄龙袍＂。');
        return true;
    }
}
