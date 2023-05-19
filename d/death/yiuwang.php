<?php
/**
*  幽枉狱
*
*/
namespace d\death;

use std\room;

class yiuwang extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '幽枉狱');
        $this->set('long', '这里不见血腥，也不闻呼声，这里的犯人全部被单独关押，寂寥无声，所有人之间无法交谈，一关就是数十年，几个鬼卒皆是天生哑人，亦
不发语，所以一片寂静尤为可怕，较之吊筋狱更让人恐惧。下一层的火坑狱会怎样？');
        $this->set('exits', array("up" => "death/diaojin",
            'down' => 'death/huokeng'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -120);

        parent::setup_room();
    }
}
