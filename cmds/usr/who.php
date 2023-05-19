<?php
/**
*   查询在线人数
*
*/

namespace cmds\usr;

class who
{
    function __construct() 
    {

    }

    public function do_cmd($ob, $para = null)
    {
        global $WHO_D;
        $WHO_D->local_whos($ob, $para);
        return true;
    }

    public function help() 
    {
        $ret = "指令格式 : who [-i][-f][-l]<br>这个指令告诉你有哪些玩家在线.";
        return $ret;
    }
}
