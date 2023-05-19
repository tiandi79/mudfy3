<?php
/**
*  刀山狱
*
*/
namespace d\death;

use std\room;

class daoshan extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '刀山狱');
        $this->set('long', '一片开阔的平地，地上倒插了数不尽的尖刀，在牛油巨烛的映照下，刀刃的寒光显得森冷无比，触目惊心，犯人戴着长链从这头走到那头，一
般走不到十分之一就倒了下去，被扎成刺猬一般，这时候鬼卒会放下挠钩，搭上来逼你从新走过，日复一日，年复一年。这里往下便是最后一类人关押的地方了，都是万死难赎之徒。');
        $this->set('exits', array("up" => "death/heian",
            'down' => 'death/xuechi'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -250);

        parent::setup_room();
    }
}
