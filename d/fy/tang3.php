<?php
/**
*  化尸堂
*
*/
namespace d\fy;

use std\msg;
use std\room;

class tang3 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '化尸堂');
        $this->set('long', '金钱帮已经买通官府，官府对金钱帮的所作所为大都视而不见。但金钱帮仇家众多，为铲除异己而双手血腥。此处正是焚烧罪状和尸体的大堂。两人高的青铜炉火焰正盛。一股焦尸的恶臭弥漫了整个大厅（ｂｕｒｎ）。');        
        $this->set('exits', array("south" => "fy/jhuang"));

        $this->set('coor/x', -20);
        $this->set('coor/y', -9);
        $this->set('coor/z', 0);

        parent::setup_room();
    }

    public function do_burn($ob, $arg = null)
    {
        $me = $ob->body;
        $exp = $me->query('combat_exp');
        $pot = $me->query('potential');
        if (null == $arg || $arg == '') {
            $ob->ssend('你烧啥东西？');
            return true;
        }

        $obj = $me->is_carry($arg);
        if (null == $obj) {
            $ob->ssend('你身上没有这东西。');
            return true;
        }
        if ($obj->is_character()) {
            $ob->ssend('你不可烧活的东西。');
            return true;
        }
        if ($obj->query('owner') != null) {
            $ob->ssend('你不可烧这样东西。');
            return true;
        }
        if ($obj->is_corpse()) {
            $me->set('combat_exp', $exp + 1);
            $me->set('potential', $pot + 1);
        }
        msg::message('vision', '$N将$n投入了青铜炉，$n转眼化为灰烬。', $me, $obj);
        $obj->move($me->get_env());
        $obj->destruct();
        return true;
    }
}
