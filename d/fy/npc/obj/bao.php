<?php
/**
*   刨花油
*
*/
namespace d\fy\npc\obj;

use std\obj;

class bao extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'bao');
        $this->set('name', '刨花油');
        $this->set('long', '气味芳香的刨花油');
        $this->set('unit', '樽');
        $this->set('value', 1000);
        $this->set_weight(50);
    }
}
