<?php
/**
*  黑暗狱
*
*/
namespace d\death;

use std\room;

class heian extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '黑暗狱');
        $this->set('long', '这里毫无光亮，无数的囚徒将在这里呆上数十年或者更长，没有一种恐惧比黑暗更能让人丛内心感到绝望了，所以通常这里的犯人很少，一旦进来，想出去可很难，不过也正是这里，可以给他们一个反省的机会。往下便是刀山狱了。');
        $this->set('exits', array("up" => "death/youguo",
            'down' => 'death/daoshan'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -240);

        parent::setup_room();
    }
}
