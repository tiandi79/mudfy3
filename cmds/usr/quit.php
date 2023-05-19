<?php
/**
*  用户退出
* 
*/

namespace cmds\usr;

class quit
{
    function __construct() 
    {

    }

    public function do_cmd($ob, $who = null)
    {
        global $GAME;
        $user = $ob->body;
        $user->do_cmd($ob, 'drop all');
        $user->save();
        if ($user->is_fighting()) {
            $ob->ssend('战斗中不能退出！');
            return false;
        }
        if (isset($user->place)) {
            $user->place->unset_carry($user);
        }
        $GAME->remove_ppl($ob);        
        $ob->ssend('欢迎下次再来！');
        $ob->destroy();
        
    }

    public function help() 
    {
        $ret = "指令格式 : quit<br>当你(玩家)想暂时离开时, 可利用此一指令。";
        return $ret;
    }
}
