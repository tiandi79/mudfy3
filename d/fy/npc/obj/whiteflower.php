<?php
/**
*   白茶花
*
*/
namespace d\fy\npc\obj;

use std\obj;

class whiteflower extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'whiteflower');
        $this->set('name', 'HIW白茶花NOR');
        $this->set('long', '冰清玉洁的白茶花。');
        $this->set('unit', '朵');
        $this->set('value', 6);
        $this->set_weight(10);
    }
}
