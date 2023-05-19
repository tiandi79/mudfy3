<?php
/**
*  警世书局
*
*/
namespace d\fy;

use std\room;

class jssju extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '警世书局');
        $this->set('long', '此间书局是风云城中卖书最多，最快的地方。这里的老板大有名气，听说是当今皇太子的老师。凡是京都出的新书，都被快马送到这里，然后刻板印刷。这里不但很多风骚文人喜欢的诗词，还卖一些粗浅的功夫书，供城中居民练来强身健体。');
        $this->set('exits', array("east" => "fy/nwind1"));
        $this->set('objects', array("fy/npc/bookseller" => 1));
        $this->set('coor/x', -10);
        $this->set('coor/y', 10);
        $this->set('coor/z', 0);
        
        parent::setup_room();
    }
}
