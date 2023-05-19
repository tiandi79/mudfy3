<?php
/**
*  赏罚堂
*
*/
namespace d\fy;

use std\msg;
use std\room;

class tang2 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '赏罚堂');
        $this->set('long', '金钱帮帮规严明，凡有贪污受贿，无事生非，调戏民女之帮徒，都会在这里受到应有的制裁。凡有巨功于金钱帮的，都会在这里受到帮主的赏赐和提拔。厅中悬条幅书道：<br><br>赏罚分明<br>');        
        $this->set('exits', array("east" => "fy/jhuang"));
        $this->set('objects', array("fy/npc/tiemian" => 1));
        $this->set('coor/x', -30);
        $this->set('coor/y', -10);
        $this->set('coor/z', 0);

        parent::setup_room();
    }

    public function do_open($ob, $arg = null)
    {
        $me = $ob->body;
        if ($arg == null || ($arg != 'picture' && $arg != '条幅'))
            return false;
        
        if (!isset($this->exits['westdown'])) {
            msg::message('vision', '$N拉起墙上的条幅，发现了一个暗门。', $me);
            $this->set('exits', array("east" => "fy/jhuang",
                'westdown' => 'fy/jsecret'));
            $this->call_out(2, 'close_path', $me);
            return true;
        }
    }

    public function close_path($me)
    {
        if (isset($this->exits['westdown'])) {
            msg::message('vision', '条幅荡了回来，又遮住了暗门。', $this);
            $this->set('exits', array("east" => "fy/jhuang"));
            return true;
        }
    }
}
