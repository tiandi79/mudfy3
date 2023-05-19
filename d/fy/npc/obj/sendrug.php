<?php
/**
*   云南白药
*
*/
namespace d\fy\npc\obj;

use std\msg;
use std\obj;

class sendrug extends obj
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'dafeng');
        $this->set('name', '大风丸');
        $this->set('value', 2000);
        $this->set('unit', '颗');
        $this->set('long', '一颗大风丸，可以用来（use）补精 。');
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

        $diff = $me->query('max_sen') - $me->query('eff_sen');
        if ($diff == 0) {
            $ob->ssend('你没有受伤！');
            return true;
        }

        if ($diff > 20)
            $diff = 20;

        msg::message('vision', '$N用大风丸增神。', $me);
	    $me->add("eff_sen", $diff);
	    $this->destruct();
        return true;
    }
}
