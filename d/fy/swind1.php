<?php
/**
*  南风大街
*
*/
namespace d\fy;

use std\room;

class swind1 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '南风大街');
        $this->set('long', '再往北走，就是风云城的中心广场。这里刚好是住在城南的大富人家去集市的必经之路，豪富的行人导致这里崎形的繁荣。大街西侧的玉龙珠宝店人进人出，拥挤不堪。东侧则是专门为有钱人的远方朋友到风云城来玩时所准备的凤求凰客栈。');
        $this->set('exits', array("south" => "fy/swind2",
                             "north" => "fy/fysquare",
                             "east" => "fy/fqkhotel",
                             "west" => "fy/yuljade"));
        $this->set('objects', array("fy/npc/mei" => 1));
        $this->set('coor/x', 0);
        $this->set('coor/y', -10);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');

        parent::setup_room();
    }
}
