<?php
/**
*  洗衣店
*
*/
namespace d\fy;

use std\room;

class washroom extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '洗衣店');
        $this->set('long', '这是一间洗衣店，这里是有钱人将衣服拿来浆洗的地方。这里的老板是一个上了年纪的老太婆，孤身一人，无儿无女，仅靠这洗衣店微薄的收入维持生活。门口有一个大木牌（ｓｉｇｎ）。');
        $this->set('exits', array("north" => "fy/ecloud3"));
        $this->set('objects', array("fy/npc/taipo" => 1));
        $this->set('coor/x', 30);
        $this->set('coor/y', -10);
        $this->set('coor/z', 0);
        $this->set("no_fight", 1);
        $this->set("no_magic", 1);
        $this->set("NONPC",1);
        
        parent::setup_room();
    }

    public function do_look($ob, $arg)
    {
        if (null == $arg || $arg != 'sign')
            return false;

        $ob->ssend('现在正紧缺人手，急需雇佣一批短工来干活（work）。');
        return true;
    }
}
