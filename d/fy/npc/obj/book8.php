<?php
/**
*   金瓶梅
*
*/
namespace d\fy\npc\obj;

use std\obj;
use std\msg;

class book8 extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'jinpingmei');
        $this->set('name', '金瓶梅');
        $this->set('long', '这是一本禁书。');
        $this->set('unit', '本');
        $this->set('value', 260);
        $this->set("material", "paper");
        $this->set_weight(600);
    }

    public function do_study($ob, $arg)
    {
        $me = $ob->body;
        if ($arg != $this->query('id')) 
            return false;
        
        $cps = rand(0, $me->query('cps'));
        switch(rand(0, 2)) {
            case 0:
                msg::message('vision','$N正欣喜若狂地翻读着' . $this->query('name') . '。', $me);
                break;
            case 1:
                msg::message('vision','$N翻了一页' . $this->query('name') . '，抬起头用色迷迷眼神看着周围。', $me);
                break;
            case 2:
                msg::message('vision','$N飞快地翻读着' . $this->query('name') . '啪＂的一声，一滴口水滴在书上。', $me);
                break;
        }
        $ob->ssend('<br>天下第一风流小说<br>金瓶梅<br><br>');
        if ($cps > 20)
            $ob->ssend('你越读越想读．．．');
        elseif ($cps > 15)
            $ob->ssend('你感到全身发热，越读越想读．．．');
        else {
            $ob->ssend('你感到一股热气从丹田直升而起．．．');
            $me->unconcious();
        }
        return true;
    }
}
