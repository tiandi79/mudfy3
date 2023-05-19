<?php
/**
*  冥想
*
*/
namespace cmds\std;

class meditate
{
    function __construct()
    {
    }

    public function do_cmd($ob, $sen_cost = 30)
    {
        $me = $ob->body;

        if ($me->is_fighting()) {
            $ob->ssend('战斗中冥思——找死吗？');
            return false;
        }

        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成，不能冥思。');
            return false;
        }

        if (!is_numeric($sen_cost) || $sen_cost < 10) {
            $ob->ssend('你最少要花 10 点「神」才能冥思。');
            return false;
        }

        if ($me->query('sen') < $sen_cost) {
            $ob->ssend('你现在精神太差了，进行冥思将会迷失，永远醒不过来！');
            return false;
        }

        if (($me->query("kee") * 100 / $me->query("max_kee")) < 70) {
            $ob->ssend('你现在身体状况太差了，无法集中精神！');
            return false;
        }

        if (($me->query("gin") * 100 / $me->query("max_gin")) < 70) {
            $ob->ssend('你现在身体状况太虚弱了，无法进入冥思的状态！');
            return false;
        }
        
        $ob->ssend('你盘膝而坐，静坐冥思了一会儿。');
        $me->receive_damage("sen", $sen_cost);
		$me->start_busy(1);
        $mana_gain = $sen_cost * ($me->query_skill("spells") /10 + $me->query_attr('spi')) / 30;
	    $mana_gain = intval(($mana_gain + rand(0, $mana_gain)) / 5);

        if ($mana_gain < 1) {
            $ob->ssend('但是当你睁开眼睛，只觉得脑中一片空白。');
            return true;
        }

        $me->add("mana", $mana_gain);
        if ($me->query("mana") > $me->query("max_mana") * 2) {
            if ($me->query("max_mana") >= ($me->query_skill("spells", 1) + $me->query_skill("spells") / 5) * 5) {
                $ob->ssend('当你的法力增加的瞬间你忽然觉得脑中一片混乱，似乎魔力的提升已经到了瓶颈。');
        	} else {
                $ob->ssend('你的魔力提高了！');
                $me->add('max_mana', 1);
            }
            $me->set("mana", $me->query("max_mana"));
        }       
        return true;
    }

    public function help() 
    {
        $ret = "指令格式 : meditate [<耗费「神」的量，预设值 30>]<br>静坐冥思，将游离的精神力有效地集中凝聚成能够用来施展法术的能量，藉以增加自己的法力。";
        return $ret;
    }
}
