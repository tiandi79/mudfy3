<?php
/**
*   meipai
*
*/
namespace questobj;

use std\obj;

class meipai extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'meipai');
        $this->set('name', 'CYN梅牌NOR');
        $this->set('unit', '块');
        $this->set("long", '西方魔教的信物。');
        $this->set('istask', 1);
        $this->set_weight(1);
    }
}
