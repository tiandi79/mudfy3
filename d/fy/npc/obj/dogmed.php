<?php
/**
*   狗皮膏药
*
*/
namespace d\fy\npc\obj;

use std\msg;
use std\obj;

class dogmed extends obj
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'gaoyao');
        $this->set('name', '狗皮膏药');
        $this->set('value', 2000);
        $this->set('unit', '块');
        $this->set('long', '一块狗皮膏药，可以用来贴（use）在身上 。');
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

        msg::message('vision', '$N用狗皮膏药增神。', $me);
	    $me->add("eff_sen", $diff);
	    $this->destruct();
        return true;
    }
}
