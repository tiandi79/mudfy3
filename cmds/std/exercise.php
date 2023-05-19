<?php
/**
*  练内功
*
*/
namespace cmds\std;

class exercise
{
    function __construct()
    {
    }

    public function do_cmd($ob, $kee_cost = 30)
    {
        $me = $ob->body;

        if ($me->is_fighting()) {
            $ob->ssend('战斗中不能练内功，会走火入魔。');
            return false;
        }

        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成，不能练内功。');
            return false;
        }

        if (null == $me->query_skill_mapped("force")) {
            $ob->ssend('你必须先用 enable 选择你要用的内功心法。');
            return false;
        }

        if (!is_numeric($kee_cost) || $kee_cost < 10) {
            $ob->ssend('你最少要花 10 点「气」才能练功。');
            return false;
        }

        if ($me->query('kee') < $kee_cost) {
            $ob->ssend('你现在的气太少了，无法产生内息运行全身经脉。');
            return false;
        }

        if (($me->query("sen") * 100 / $me->query("max_sen")) < 70) {
            $ob->ssend('你现在精神状况太差了，无法凝神专一！');
            return false;
        }

        if (($me->query("gin") * 100 / $me->query("max_gin")) < 70) {
            $ob->ssend('你现在精力不够，无法控制内息的流动！');
            return false;
        }
        
        $ob->ssend('你坐下来运气用功，一股内息开始在体内流动。');
        $me->receive_damage("kee", $kee_cost);
		$me->start_busy(2);
        $force_gain = $kee_cost * ($me->query_skill("force") /10 + $me->query_attr('con')) / 30;
	    $force_gain = intval(($force_gain + rand(0, $force_gain)) / 5);

        if ($force_gain < 1) {
            $ob->ssend('但是当你行功完毕，只觉得全身发麻。');
            return true;
        }

        $me->add("force", $force_gain);
        if ($me->query("force") > $me->query("max_force") * 2) {
            if ($me->query("max_force") >= ($me->query_skill("force", 1) + $me->query_skill("force") / 5) * 5) {
                $ob->ssend('当你的内息遍布全身经脉时却没有功力提升的迹象，似乎内力修为已经遇到了瓶颈！');
        	} else {
                $ob->ssend('你的内力增强了！');
                $me->add('max_force', 1);
            }
            $me->set("force", $me->query("max_force"));
        }       
        return true;
    }

    public function help() 
    {
        $ret = "指令格式 : exercise [<耗费「气」的量，预设值 30>]<br>运气练功，控制体内的气在各经脉间流动，藉以训练人体肌肉骨骼的耐力、爆发力，并且用内力的形式将能量储备下来。";
        return $ret;
    }
}
