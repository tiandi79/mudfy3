<?php
/**
*  千银当铺
*
*/
namespace d\fy;

use std\room;

class qianyin extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '千银当铺');
        $this->set('long', '此当铺是南风大街对面的千金楼所设。以方便手头不宽的嫖客。千金楼的姑娘们也经常光顾这里，典当或是卖掉客人们高兴之余所赏赐的小玩意儿。此当铺虽然是千金楼所属，但却是童叟无欺。当铺挂有牌（ｓｉｇｎ）一块。');
        $this->set('exits', array("west" => "fy/swind4"));
        $this->set('objects', array("fy/npc/hockowner" => 1));
        $this->set('coor/x', 10);
        $this->set('coor/y', -40);
        $this->set('coor/z', 0);
        
        parent::setup_room();
    }

    public function do_look($ob, $arg)
    {
        if ($arg == null || $arg != 'sign')
            return false;

        $ob->ssend('这里是当铺，目前我们提供的服务有：<br>pawn	    典当货物。<br>value       估价货物。<br>sell        卖断货物。<br>redeem      赎回货物。');
        return true;
    }
}
