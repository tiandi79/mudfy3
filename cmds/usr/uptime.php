<?php
/**
*  显示游戏运行时间
*
*/

namespace cmds\usr;

use adm\daemons\chinesed;

class uptime
{
    private $startat;
    function __construct() 
    {

    }

    public function do_cmd($ob) 
    {
        global $CHINESE_D, $GAME;
        $t = time() - $GAME->game_start;
        $s = $t % 60;
        $t = $t / 60;
        $m = $t % 60;
        $t = $t / 60;
        $h = $t % 24;
        $t = $t / 24;
        $d = $t;
        $ret = '';

        if (isset($d))
            $ret = $CHINESE_D->chinese_number($d) . "天";
        else $ret = "";

        if ($h) 
            $ret .= $CHINESE_D->chinese_number($h) . "小时";
	    if ($m)
            $ret .= $CHINESE_D->chinese_number($m) . "分";
	    $ret .= $CHINESE_D->chinese_number($s) . "秒";

	    $ob->ssend(MUD_NAME. "已经运行了" . $ret . "。");
    }

    public function help() 
    {
        $ret = "指令格式 : uptime<br>这个指令告诉你风云已经连续运行了多久.";
        return $ret;
    }
}
