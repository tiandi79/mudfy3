<?php
/**
*  alert
*
*/
namespace cmds\std;

use std\msg;

class alert
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null)
    {
        $me = $ob->body;
        if ($me->query('class') != 'official') {
            $ob->ssend('你不是朝廷命官，还是自己照顾自己吧！');
            return true;
        }
        if (!$me->is_fighting()) {
            $ob->ssend('好象没有人要杀你！');
            return true;
        }

        if ($me->query('sen') < 100) {
            $ob->ssend('你的神太差了！');
            return true;
        }   

        $leadership = $me->query_skill('leadership', 1);
        $strategy = $me->query_skill('strategy', 1);
        if ($leadership < 10 || $strategy < 10) {
            $ob->ssend('你兵法和用人之技太差了，没人愿意理你！');
            return true;
        }
        $max_guard = $strategy * $leadership / 10000 + 1;
	    if ($me->query_temp("max_guard") > $max_guard) {
            $ob->ssend('以你现在的官位，你已经受道足够的保护！');
            return true;
        }
        $me->receive_damage("sen", 100);
        global $OBJECT;
        $soldier = $OBJECT->create_objects('/obj/npc/danei');
        $soldier->move($me->get_env());
        $soldier->set('possessed', $me);
        $soldier->invocation($me, $strategy + $leadership);
        $me->add_temp('max_guard', 1);
        $me->remove_all_killer();
        msg::message('vision', '<br>HIB$N发出一声长求援！<br>$n应声而来！NOR', $me, $soldier);
        return true;
    }

    public function help() 
    {
        $ret = "这个指令让官员呼唤高手来保护自己。能否招呼出高手，呼出高手水平的高低就要看官员官职的大小了。";
        return $ret;
    }
}
