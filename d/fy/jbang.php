<?php
/**
*  帮主堂
*
*/
namespace d\fy;

use std\room;

class jbang extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '帮主堂');
        $this->set('long', '屋子很大，这么大的屋子，只有一个窗户，很小的窗户，离地很高。窗户是关着的，看不到外面的景色。门也很小，肩稍宽的人，就只能侧身而入。墙上漆着白色的漆，漆得很厚，仿佛不愿人看出这墙是石壁，是土，还是铜铁所筑。角落里有两张床，木床。床上的被褥很干净，却很简朴。除此之外，屋里只有一张很大的桌子。桌子上堆埋了各式各样的账册和卷宗。屋里没有椅子，连一张椅子都没有。');        
        $this->set('exits', array("north" => "fy/jhuang1"));
        $this->set('objects', array("fy/npc/huangyi" => 3));
        $this->set('objects', array("fy/npc/jinwuming" => 1,
            'fy/npc/shangguan' => 1));
        $this->set("valid_startroom", 1);
        $this->set('coor/x', -20);
        $this->set('coor/y', -41);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
