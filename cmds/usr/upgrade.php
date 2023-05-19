<?php
/**
*  用户退出
* 
*/

namespace cmds\usr;

class upgrade
{
    function __construct() 
    {

    }

    public function do_cmd($ob, $arg = null)
    {
        if ($arg != null && $arg == UPGRADE_PASSWORD ) {
            $ob->body->set('level', 'wizard');
            $ob->ssend('权限已经更改为巫师。');
        }
        else {
            $ob->body->set('level', 'player');
            $ob->ssend('权限已经更改为玩家。');
        }
    }

    public function help() 
    {
        $ret = "指令格式 : upgrade <提升密码><br>提升玩家到巫师的权限。";
        return $ret;
    }
}
