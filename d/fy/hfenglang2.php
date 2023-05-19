<?php
/**
*  长廊
*
*/
namespace d\fy;

use std\room;

class hfenglang2 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '长廊');
        $this->set('long', '这里是给到这儿的小姐们更衣入浴的，地上是五光十色的彩带和香味扑鼻的花瓣,昂贵的衣裳满地都是，透过蒙蒙水雾，你可以看到白腻的身躯，修长的大腿，坚挺的胸膛，和乌黑的长发。。。。。。');
        $this->set('exits', array("south" => "fy/hfenglang1",
                             "east" => "fy/hfenglang3"));

        $this->set('coor/x', 21);
        $this->set('coor/y', 40);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
