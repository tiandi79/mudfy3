<?php
/**
*  浸龙浴池
*
*/
namespace d\fy;

use std\msg;
use std\room;

class jlongpool extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '浸龙浴池');
        $this->set('long', '一入门，热气扑面，白白的水气立刻包围了你。你依稀看到一个巨大的檀木水池,水呈碧绿，散发着一种奇特的药香，水面上还漂着一片片红红的花瓣儿，你真想一下子跳（ｊｕｍｐ）进去，闭上眼睛好好的放松一下。');
        $this->set('exits', array("east" => "fy/jlonglang3"));
        $this->set('objects', array("fy/npc/troublemaker" => 2));
        $this->set('coor/x', -40);
        $this->set('coor/y', 40);
        $this->set('coor/z', 0);
        //$this->set("no_fight",1);
	    $this->set("no_magic",1);

        parent::setup_room();
    }

    public function do_jump($ob, $arg)
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
