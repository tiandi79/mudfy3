<?php
/**
*  风云雅阁
*
*/
namespace d\fy;

use std\msg;
use std\room;

class fyyage extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '风云雅阁');
        $this->set('long', '这里专门招待江湖上万儿极响亮的人物。能有幸坐在这儿的，不是一掷千金的豪客，就是跺跺脚江湖四颤的一方霸主。整间房子的中央只有一张上等翠玉打磨成的八仙桌，桌上放着四只御赐金杯。三面的墙上挂满了字画，剩下的一面是一道一垂及地的红布挂帘。');
        $this->set('exits', array("east" => "fy/fysf",
            'down' => 'fy/fyge'));
        $this->set('objects', array("fy/npc/servent" => 1));

        $this->set('coor/x', 10);
        $this->set('coor/y', 10);
        $this->set('coor/z', 10);
        $this->set("NONPC",1);
        
        parent::setup_room();
    }

    public function do_open($ob, $arg)
    {
        $me = $ob->body;
        if ($arg == null)
            return false;
        elseif ($arg == 'curtain' || $arg == '挂帘') {
            $ob->ssend('你掀开红布挂帘。');
            if ($me->query('force_factor') >= 100) {
                if ($this->query_temp('opened') == null) {
                    $ob->ssend('推开了后面向北的一扇暗门。');
                    $this->set('exits', array("east" => "fy/fysf",
                        'down' => 'fy/fyge',
                        'north' => 'fy/fysecret'));
                    $this->call_out(3, 'close_path', $me);
                    return true;
                } else
                    return false;
            } else {
                $ob->ssend('试着推了推后面的暗门，但没有推开。');
                return true;
            }
        } else {
            $ob->ssend('你要掀开什么？');
            return true;
        }
    }

    public function close_path($me)
    {
        $this->del_temp('opened');
        $this->set('exits', array("east" => "fy/fysf",
            'down' => 'fy/fyge'));
        if ($me->get_env() == $this)
            msg::message_text('vision', '红布挂帘又落了下来，盖住了暗门。', $this);
    }

    public function valid_leave($me, $dir)
    {
        if ($dir == 'north' && ($servent = $this->is_carry('servent'))) {
            msg::message('vision', '$N对$n喝道：想进去？宰了我再说！！' , $servent, $me);
            $servent->kill_ob($me);
            return false;
        }
        return true;
    }
}
