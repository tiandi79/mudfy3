<?php
/**
*  枫叶泉
*
*/
namespace d\fy;

use std\msg;
use std\room;

class hfengpool extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '枫叶泉');
        $this->set('long', '风云城中的枫叶泉是方圆五百里最著名的一口温泉。水温适中，泉水呈淡红,故而得名枫叶。它不但有去腐生肌的奇效，据说还有延年益寿的妙用。武林第一美人林仙儿每天都以此泉水浣面（ｗａｓｈ），来保持她如花似玉的容貌。');
        $this->set('exits', array("west" => "fy/hfenglang3"));
        $this->set('objects', array("fy/npc/xianu" => 2));
        $this->set('coor/x', 45);
        $this->set('coor/y', 40);
        $this->set('coor/z', 0);
        //$this->set("no_fight",1);
	    $this->set("no_magic",1);

        parent::setup_room();
    }

    public function do_wash($ob, $arg)
    {
        $me = $ob->body;
        $wait = rand(0, (40 - $me->query('con') * 2));
        if ($wait <= 20)
            $wait = 21;
        msg::message('vision', '$N噗嗵一声跳进浴池．', $me);
        $ob->ssend('你感到全身无比的舒泰．．');
        $this->call_out($wait, 'remove_curehimup', $me);
        return true;
    }

    public function remove_curehimup($me)
    {
        if ($me == null)
            return false;
        if ($me && $me->get_env() == $this) {
            msg::message('vision', '$N的精气神全恢复了！！', $me);
            $me->set('eff_gin', $me->query('max_gin'));
            $me->set('eff_kee', $me->query('max_kee'));
            $me->set('eff_sen', $me->query('max_sen'));
            $me->set('gin', $me->query('max_gin'));
            $me->set('kee', $me->query('max_kee'));
            $me->set('sen', $me->query('max_sen'));
            return true;
        }
        return false;
    }
}
