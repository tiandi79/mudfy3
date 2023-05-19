<?php
/**
*  脱壳狱
*
*/
namespace d\death;

use std\room;

class tuoke extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '脱壳狱');
        $this->set('long', '这里似乎和剥皮狱差不多，不过这里的犯人是皮肉和骨头分离，把活人变为骷髅，然后再把皮肉贴上去，循环往复，其间痛苦实在难以抵挡，许多囚犯经历这层以后变改邪归正，从此成为良善之徒。你看见了不少似曾相识的面孔。再往下会是什么呢？');
        $this->set('exits', array("up" => "death/hanbing",
            'down' => 'death/chouchang'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -210);

        parent::setup_room();
    }
}
