<?php
/**
*  南宫钱庄
*
*/
namespace d\fy;

use std\room;

class nanbank extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '南宫钱庄');
        $this->set('long', '中原南宫世家，家财万贯，产业不可胜数。此间钱庄黑匾红字，正是南宫产业之一。南宫钱庄的银票信誉极好，大江南北都可兑现。就是富可敌国的金钱帮，也难望其项背。钱庄中央有一红木柜台，半人多高，上有牌（ｓｉｇｎ）一块。');
        $this->set('exits', array("west" => "fy/swind5"));
        $this->set('objects', array("fy/npc/nangong" => 1));
        $this->set('coor/x', 10);
        $this->set('coor/y', -50);
        $this->set('coor/z', 0);
        
        parent::setup_room();
    }

    public function do_look($ob, $arg)
    {
        if ($arg == null || $arg != 'sign')
            return false;

        $ob->ssend('这里是钱庄，目前我们提供的服务有：<br>convert     兑换钱币。<br>withdraw    提取存款。<br>deposit     存入钱币。<br>balance     查询存款。');
        return true;
    }
}
