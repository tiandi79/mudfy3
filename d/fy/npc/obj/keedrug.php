<?php
/**
*   云南白药
*
*/
namespace d\fy\npc\obj;

use std\msg;
use std\obj;

class keedrug extends obj
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'baiyao');
        $this->set('name', '云南白药');
        $this->set('value', 2000);
        $this->set('unit', '包');
        $this->set('long', '一包云南白药，可以用来（use）补精 。');
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

        $diff = $me->query('max_kee') - $me->query('eff_kee');
        if ($diff == 0) {
            $ob->ssend('你没有受伤！');
            return true;
        }

        if ($diff > 20)
            $diff = 20;

        msg::message('vision', '$N用云南白药疗伤。', $me);
	    $me->add("eff_kee", $diff);
	    $this->destruct();
        return true;
    }
}
