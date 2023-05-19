<?php
/**
*  油锅狱
*
*/
namespace d\death;

use std\room;

class youguo extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '油锅狱');
        $this->set('long', '这里是最常听闻的油锅狱，所谓“战战兢兢，悲悲切切，皆因强暴欺良善，藏头缩颈苦伶仃”说得便是这里。在牛头，马面的驱赶下，犯人一个个得走进油锅，被炸的骨焦肉烂，随后立刻被复原，一次一次，过往囚犯的诚惶诚恐之色让你暗叹地狱法度之严。下面一层不闻人声，亦无亮光，不知道又会是什么。');
        $this->set('exits', array("up" => "death/chouchang",
            'down' => 'death/heian'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -230);

        parent::setup_room();
    }
}
