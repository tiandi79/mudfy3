<?php
/**
*  镖局内院
*
*/
namespace d\fy;

use std\msg;
use std\room;

class ginhall extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '镖局内院');
        $this->set('long', '这里是镖局伙计们辛苦之余，休息放松的院子。院子的中央横七竖八的架着几根竹竿，想必是用来晾晒衣服的。院子的周围有几间小房，是供没有家的年青伙计们住的所在。');        
        $this->set('exits', array("west" => "fy/ghall",
            'north' => 'fy/gke2',
            'east' => 'fy/gke1',
            'south' => 'fy/gke3'));

        $this->set('coor/x', 20);
        $this->set('coor/y', 40);
        $this->set('coor/z', 0);

        parent::setup_room();
    }

    public function do_look($ob, $arg)
    {
        if ($arg == null || ($arg != 'bamboo' && $arg != '竹竿'))
            return false;
       
        $ob->ssend('这些竹竿好象可以挪动（ｍｏｖｅ）。');
        return true;
    }

    public function do_move($ob, $arg)
    {
        if ($arg == null || ($arg != 'bamboo' && $arg != '竹竿'))
            return false;
        if ($this->query('amount') > 10)
            return false;
        else {
            $me = $ob->body;
            msg::message('vision', '$N挪了下竹竿，一只蟑螂飞块地爬了出来。', $me);
            global $OBJECT;
            $cock = $OBJECT->create_objects('d/fy/npc/cockroach');
            $cock->move($this);
            $this->add('amount', 1);
            return true;
        }
    }
}
