<?php
/**
*   虎骨丸
*
*/
namespace d\fy\npc\obj;

use std\msg;
use std\obj;

class gindrug extends obj
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'hugu');
        $this->set('name', '虎骨丸');
        $this->set('value', 2000);
        $this->set('unit', '颗');
        $this->set('long', '一颗虎骨丸，可以用来（use）补精 。');
        $this->set_weight(60);
    }

    public function do_use($ob, $arg)
    {
        if ($arg == null || $arg != $this->query('id')) {
            return false;
        }

        $me = $ob->body;
        if ($me->is_fighting()) {
            $ob->ssend('战斗中不能用药！！');
            return true;
        }

        $diff = $me->query('max_gin') - $me->query('eff_gin');
        if ($diff == 0) {
            $ob->ssend('你没有受伤！');
            return true;
        }

        if ($diff > 20)
            $diff = 20;

        msg::message('vision', '$N用虎骨丸补精。', $me);
	    $me->add("eff_gin", $diff);
	    $this->destruct();
        return true;
    }
}
