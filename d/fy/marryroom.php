<?php
/**
*  鸳鸯亭
*
*/
namespace d\fy;

use std\room;

class marryroom extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '鸳鸯亭');
        $this->set('long', '你现在正站在鸳鸯亭里，这里是专门替人缔结婚约和解除婚约的地方，城里所有的夫妇都是在这里喜结良缘的，就连附近镇子也有许多慕名而来的年青人．靠近门口的地方有一块乌木雕成的招牌（ｓｉｇｎ）。');
        $this->set('exits', array("north" => "fy/ecloud1"));
        $this->set('objects', array("fy/npc/meipo" => 1));
        $this->set('coor/x', 10);
        $this->set('coor/y', -1);
        $this->set('coor/z', 0);
        
        parent::setup_room();
    }

    public function do_look($ob, $arg)
    {
        if (null == $arg || $arg != 'sign')
            return false;

        $ob->ssend('缔结（ｍａｒｒｙ）或解除（ｄｉｖｏｒｃｅ）婚约。');
        return true;
    }
}
