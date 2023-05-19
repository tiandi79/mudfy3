<?php
/**
*  镖局货仓
*
*/
namespace d\fy;

use std\msg;
use std\room;

class gcang extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '镖局货仓');
        $this->set('long', '金狮镖局声誉方日中天，从未失镖。顾主的货物在这里堆积如山。镖局的伙计们正在手忙脚乱的往镖车上装载货物。虽然每个伙计都已尽力而为，但还是忙不过来。');
        $this->set('exits', array("south" => "fy/goldlion"));
        $this->set('objects', array("fy/npc/huoji" => 3));
        $this->set('coor/x', 10);
        $this->set('coor/y', 50);
        $this->set('coor/z', 0);

        parent::setup_room();
    }

    public function do_work($ob, $arg)
    {
        $me = $ob->body;
        msg::message('vision', '$N帮镖局的伙计往镖车上装载货物，真辛苦真累！！', $me);
        $me->add("gin", -30);
        $me->add("sen", -30);
        $me->set_mark('金狮', time());
        $me->start_busy(2);
        return true;
    }
}
