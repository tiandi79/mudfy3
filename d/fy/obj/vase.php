<?php
/**
*   白玉瓶
*
*/
namespace d\fy\obj;

use std\throwing;

class vase extends throwing
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'vase');
        $this->set('name', '白玉瓶');
        $this->set('unit', '个');
        $this->set('long', '一个制作精美的上等白玉瓶。');
        $this->set('value', 1);
        $this->set("no_get", 1);
	    $this->set("no_shown", 1);
        $this->set_weight(500);
	    $this->set_max_encumbrance(8000);
    }

    public function is_container() {
        return true;
    }
}
