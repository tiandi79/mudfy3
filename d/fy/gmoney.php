<?php
/**
*  镖局账房
*
*/
namespace d\fy;

use std\msg;
use std\room;

class gmoney extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '镖局账房');
        $this->set('long', '这里是金狮镖局出入镖银的账房，整间屋子是由坚硬的花岗石砌成的。连唯一的一个小窗上都镶满拇指粗细的钢条。屋角有小床。这里由总镖头最亲信的人日夜把守。不但如此，房中还有黄铜警铃，铃声一响，镖局伙计们就会蜂拥而至。');
        $this->set('exits', array("south" => "fy/ghall"));
        $this->set('objects', array("fy/npc/xiansheng" => 1));
        $this->set('coor/x', 20);
        $this->set('coor/y', 50);
        $this->set('coor/z', 0);
        $this->create_door("south", "铁门", "north", 1);
        parent::setup_room();
    }

    public function do_look($ob, $arg)
    {
        if (null == $arg || ($arg != 'bed' && $arg != '小床'))
            return false;

        $ob->ssend('这个小床似乎可以推开(push)。');
        return true;
    }

    public function do_push($ob, $arg)
    {
        if (null == $arg || ($arg != 'bed' && $arg != '小床'))
            return false;
        $me = $ob->body;
        if ($xiansheng = $this->is_carry('xiansheng')) {
            msg::message('vision', '$N用很一种奇怪的眼神瞄$n。', $xiansheng, $me);
            return true;
        }
        $exits = $this->query('exits');
        if (!isset($exits['down'])) {
            msg::message('vision', '$N把小床推开发现了一条密道。', $me);
            $this->set('exits', array('down' => 'fy/secretroom',
                'south' => 'fy/ghall'));
            global $OBJECT;
            $room = $OBJECT->get_room('fy/secretroom');
            $room->set('exits', array('up' => 'fy/gmoney'));
            return true;
        }
        else {
            msg::message('vision', '$N把小床推过来掩盖住密道。', $me);
            $this->set('exits', array('south' => 'fy/ghall'));
            global $OBJECT;
            $room = $OBJECT->get_room('fy/secretroom');
            $room->set('exits', array());
            return true;
        }
    }
}
