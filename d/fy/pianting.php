<?php
/**
*  银钩赌坊偏厅
*
*/
namespace d\fy;

use std\msg;
use std\room;

class pianting extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '银钩赌坊偏厅');
        $this->set('long', '四面的墙壁粉刷的象雪洞一样，上面挂满了古今名家的字画。最大的幅山水，排在正中，却是个无名小卒画的，把云雾凄迷的远山，画得就象打翻了墨水缸一样。和那些名家的杰作一比，实在是不堪入目，令人不敢领教。');
        $this->set('exits', array("south" => "fy/dating"));
        $this->set('objects', array("fy/npc/leng" => 1,
            'fy/npc/fangyufei' => 1));
        $this->set('coor/x', -20);
        $this->set('coor/y', -20);
        $this->set('coor/z', 0);
        
        parent::setup_room();
    }

    public function do_look($ob, $arg)
    {
        if (null == $arg || ($arg != 'picture' && $arg != '字画'))
            return false;

        $ob->ssend('这幅字画似乎可以掀开(open)。');
        return true;
    }

    public function do_open($ob, $arg = null)
    {
        $me = $ob->body;
        if ($arg == null || ($arg != 'picture' && $arg != '字画'))
            return false;
        
        if (!isset($this->exits['west'])) {
            msg::message('vision', '$N拉起墙上的条幅，发现了一个暗门。', $me);
            $this->set('exits', array("west" => "fy/zhoulang",
                'south' => 'fy/dating'));
            $this->call_out(2, 'close_path', $me);
            return true;
        }
    }

    public function close_path($me)
    {
        if (isset($this->exits['west'])) {
            msg::message('vision', '山水画荡了回来，又遮住了暗门。', $this);
            $this->set('exits', array("south" => "fy/dating"));
            return true;
        }
    }
}
