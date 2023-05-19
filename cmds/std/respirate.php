<?php
/**
*  灵力修行
*
*/
namespace cmds\std;

class respirate
{
    function __construct()
    {
    }

    public function do_cmd($ob, $gin_cost = 30)
    {
        $me = $ob->body;

        if ($me->is_fighting()) {
            $ob->ssend('战斗也是一种修行，但不能和灵力的修行同时进行。');
            return false;
        }

        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成，不能修行。');
            return false;
        }

        if (!is_numeric($gin_cost) || $gin_cost < 10) {
            $ob->ssend('你最少要花 10 点「精力」才能进行修行。');
            return false;
        }

        if ($me->query('gin') < $gin_cost) {
            $ob->ssend('你现在精力不足，无法修行灵力！');
            return false;
        }

        if (($me->query("kee") * 100 / $me->query("max_kee")) < 70) {
            $ob->ssend('你现在身体状况太差了，无法集中精神！');
            return false;
        }

        if (($me->query("sen") * 100 / $me->query("max_sen")) < 70) {
            $ob->ssend('你现在精神状况太差了，无法控制自己的心灵！');
            return false;
        }
        
        $ob->ssend('你闭上眼睛开始打坐。');
        $me->receive_damage("gin", $gin_cost);
		$me->start_busy(1);
        $atman_gain = $gin_cost * ($me->query_skill("magic") /10 + $me->query_attr('spi')) / 30;
	    $atman_gain = intval(($atman_gain + rand(0, $atman_gain)) / 5);

        if ($atman_gain < 1) {
            $ob->ssend('但是你一不小心却睡著了。');
            return true;
        }

        $me->add("atman", $atman_gain);
        if ($me->query("atman") > $me->query("max_atman") * 2) {
            if ($me->query("max_atman") >= ($me->query_skill("magic", 1) + $me->query_skill("magic") / 5) * 5) {
                $ob->ssend('你忽然觉得一阵天旋地转，头涨得像要裂开一样，似乎灵力的修行已经遇到了瓶颈。');
        	} else {
                $ob->ssend('你的道行提高了！');
                $me->add('max_atman', 1);
            }
            $me->set("atman", $me->query("max_atman"));
        }       
        return true;
    }

    public function help() 
    {
        $ret = "指令格式 : respirate [<耗费「精」的量，预设值 30>]<br>打坐修行，利用「炼精化气，炼气化神，炼神还虚」的方法将你的精力转变成灵力。";
        return $ret;
    }
}
