<?php
/**
*  打坐
*
*/
namespace cmds\std;

use std\msg;

class dazuo
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null)
    {
        $me = $ob->body;

        if ($me->is_fighting()) {
            $ob->ssend('战斗中不能打坐，会走火入魔的。');
            return false;
        }

        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成！');
            return false;
        }

        $env = $me->get_env();
        if ($env->query('no_dazuo') != null) {
            $ob->ssend('这个地方不可以打坐。');
            return false;
        }

        msg::message('vision', '$N盘腿跌坐在地上，闭上眼睛开始调息打坐。', $me);
        $me->set_temp("disable_inputs", 1);
        $me->set_temp("block_msg/all", 1);
	    $me->set_temp("is_unconcious", 1);
        $me->set("disable_type", "HIG<打坐中>NOR");
	    $me->set_temp("in_dazuo", 1);
        $me->call_out(rand(0, (50 - $me->query('con'))), 'remove_dazuo', $me, $this);

        if ($me->query("food") > 0 && $me->query("water") > 0) {
            $kee1 = $me->query("kee");
            $mkee2 = $me->query("eff_kee");
	        if (($me->query("kee") < $me->query("eff_kee")) && ($mkee2 / 2) > $kee1)
		        $me->set("kee", $kee1 * 2);
		    else  
                $me->set("kee", $mkee2);
            
            $gin1 = $me->query("gin");
            $mgin2 = $me->query("eff_kee");
	        if (($me->query("gin") < $me->query("eff_gin")) && ($mgin2 / 2) > $gin1)
		        $me->set("gin", $gin1 * 2);
		    else
                $me->set("gin", $mgin2);

            $sen1 = $me->query("sen");
            $msen2 = $me->query("eff_sen");
	        if (($me->query("sen") < $me->query("eff_sen")) && ($msen2 / 2) > $sen1)
		        $me->set("sen", $sen1 * 2);
		    else
                $me->set("sen", $msen2);
            
            $me->set("food", intval($me->query("food") / 2));
            $me->set("water", intval($me->query("water") / 2));
        }
        return true;
    }

    public function remove_dazuo($me)
    {
        $me->del_temp("disable_inputs");
        $me->set("disable_type", null);
        $me->del_temp("block_msg/all");
	    $me->del_temp("in_dazuo");
        $me->del_temp("is_unconcious");
        if(!$me->is_ghost())
            msg::message('vision', '$N从忘我的境界中回神敛气，睁开了眼睛。', $me);
        else
            $me->get_conn()->ssend('你从忘我的境界中回神敛气，睁开了眼睛。');
    }

    public function help() 
    {
        $ret = "指令格式 : dazuo<br>使你进入忘我的打坐状态中，可能可以增快精力，气血，心神，灵力，内力，法力的恢复速度。";
        return $ret;
    }
}
