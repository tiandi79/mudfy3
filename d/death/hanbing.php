<?php
/**
*  寒冰狱
*
*/
namespace d\death;

use std\room;

class hanbing extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '寒冰狱');
        $this->set('long', '冰是昆仑山的千年寒冰，无数的犯人正赤身裸体的走在冰上，这里管得都是“垢面蓬头，愁眉皱眼，大斗小秤欺痴蠢，致使灾屯累自身”的奸商，用别人的损失换来自己的金银，结果仍是一无所有的在冰上走，对人用刑，地狱之法果然不同凡间。');
        $this->set('exits', array("up" => "death/chebeng",
            'down' => 'death/tuoke'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -200);

        parent::setup_room();
    }
}
