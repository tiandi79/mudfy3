<?php
/**
*  吊筋狱
*
*/
namespace d\death;

use std\room;

class diaojin extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '吊筋狱');
        $this->set('long', '这里是地狱的第一层，地狱共十八层，每三层关押同一类人犯，故实际关押六种犯人。这第一种三层关押的是“寂寂寥寥，烦烦恼恼，尽是生
前作下千般业，死后通来受罪名”，在这吊筋狱中关押的皆是罪名较轻之人，受挑筋之苦，遍地血腥，呻吟声此起彼伏，几个鬼卒来回逡巡，再往下便是幽枉狱。');
        $this->set('exits', array("up" => "death/diyu",
            'down' => 'death/yiuwang'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -110);

        parent::setup_room();
    }
}
