<?php
/**
*  张家铁铺
*
*/
namespace d\fy;

use std\room;

class smithy extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '张家铁铺');
        $this->set('long', '风云老少都喜欢在这里打造称手的铁器，从火炉中冒出的火光将墙壁映得通红，屋子的角落里堆满了各式铁器的完成品或未完成品，像是锄
头、铁锤、铲子、长剑等，叮叮当当的声音敲得满屋子响。门口有一个大木牌（ｓｉｇｎ）。');
        $this->set('exits', array("south" => "fy/ecloud3"));
        $this->set('objects', array("fy/npc/smith" => 1));
        $this->set('coor/x', 30);
        $this->set('coor/y', 10);
        $this->set('coor/z', 0);
        
        parent::setup_room();
    }

    public function do_look($ob, $arg)
    {
        if (null == $arg || $arg != 'sign')
            return false;

        $ob->ssend('目前我们可订作（ding）：<br>铁斧（axe），单刀（blade），匕首（dagger），钢叉（fork），铁锤（hammer），
禅杖（staff），铁剑（sword），铁鞭（whip）长矛（spear），板指（banzhi）<br>每件十两黄金．<br>例子：ding sword 碧血剑  bysword tie<br>张铁匠就会用你带来的铁料帮你作一把剑叫做＂碧血剑＂。');
        return true;
    }
}
