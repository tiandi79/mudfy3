<?php
/**
*   面目空白的木像
*
*/
namespace d\fy\obj;

use std\obj;

class muou extends obj
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'muxiang');
        $this->set('name', '面目空白的木像');
        $this->set('unit', '个');
        $this->set('long', '面目空白的木像。');
        $this->set('value', 10);
        $this->set_weight(50);
	    $this->set_max_encumbrance(8000);
    }
}
