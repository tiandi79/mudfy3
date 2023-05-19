<?php
/**
*  西云大路
*
*/
namespace d\fy;

use std\msg;
use std\room;

class wcloud1 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '西云大路');
        $this->set('long', '风云广场在东，知府衙门在西，这里是风云城中风骚文人丛聚之地。据说天下赫赫有名的小李探花就是在这里中的秀才。南边的考场每年都举行一次选拔考试，前三名送入京都再试。北面则是探花诗台，是风骚文人们留下他们得意之作的地方。');
        $this->set('exits', array("south" => "fy/examp",
                             "north" => "fy/poemp",
                             "east" => "fy/fysquare",
                             "west" => "fy/wcloud2"));
        $this->set('objects', array("fy/npc/song" => 1,
            'fy/npc/xiwei' => 4));
        $this->set('coor/x', -10);
        $this->set('coor/y', 0);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');

        parent::setup_room();
    }

    public function valid_leave($me, $dir)
    {
        if ($dir == 'north' && ($qinwei = $this->is_carry('qinwei'))) {
            msg::message('vision', '$N向$n喝道：＂皇公子所到之处，闲杂人等不可入内！' , $qinwei, $me);
            return false;
        }

        if ($dir == 'north' && $me->get_conditions() != null && count($me->get_conditions() >= 1)) {
            $me->get_conn()->ssend('探花诗台不是你的坟场。');
            return false;
        }
        return true;
    }
}
