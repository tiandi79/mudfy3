<?php
/**
*  关闭游戏
*  
*/
namespace cmds\wiz;

class shutdown
{
    function __construct() 
    {

    }

    public function do_cmd($ob, $arg = null) 
    {
        $me = $ob->body;
        if (!$ob->body->wizardp()) {
            $ob->ssend("什么？");
            return;
        }

        global $GAME;
        $GAME->shutdown($me, 5);
    }

    public function help() 
    {
        $ret = "指令格式: shutdown <原因>关闭服务器，连续通知5次后，游戏进入维护状态。";
        return $ret;
    }
}