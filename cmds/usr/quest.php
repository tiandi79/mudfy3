<?php
/**
*  显示任务
*
*/

namespace cmds\usr;

class quest
{
    function __construct() 
    {

    }

    public function do_cmd($ob) 
    {
        $me = $ob->body;
        if ($me->query('quest') == null) {
            $ob->ssend('你现在没有任何任务！');
            return true;
        }
        
        $quest = $me->query('quest');
        if (is_array($quest))
            $ob->ssend('你现在的任务是' . $quest['quest_type'] . '『' . $quest['quest'] . '』。');
        else
            $ob->ssend('你现在的任务是关于' . $quest);
        $nowtime = $me->query("quest_time") - time();
	    if ($nowtime > 0)
		    $ob->ssend($this->time_period($nowtime));
	    else
		    $ob->ssend('但是你已经没有足够的时间来完成它了。');
        return true;
    }

    private function time_period($timep)
    {
        $t = $timep;
        $s = intval($t % 60);
        $t /= 60;
        $m = intval($t % 60);
        $t /= 60;
        $h = intval($t % 24);
        $t /= 24;
        $d = intval($t);

        global $CHINESE_D;
        if ($d > 0) 
            $ret = $CHINESE_D->chinese_number($d) . "天";
        else 
            $ret = "";

        if ($h > 0) 
            $ret .= $CHINESE_D->chinese_number($h) . "小时";
        if ($m > 0) 
            $ret .= $CHINESE_D->chinese_number($m) . "分";
        $ret .= $CHINESE_D->chinese_number($s) . "秒";
        return '你还有' . $ret . '去完成它。';
    }

    public function help() 
    {
        $ret = "指令格式 : quest<br>这个指令可以显示出你当前的任务。";
        return $ret;
    }
}
