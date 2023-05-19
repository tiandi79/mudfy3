<?php
/**
*  用户保存
* 
*/

namespace cmds\usr;

class save
{
    function __construct() 
    {

    }

    public function do_cmd($ob, $who = null)
    {
        global $GAME;
        $user = $ob->body;

        $user->save();
        if ($user->is_fighting()) {
            $ob->ssend('战斗中不能保存！');
            return false;
        }

        if ($env = $user->get_env()) {
            if ($env->query('valid_startroom') != null) {
                $user->set('startroom', $env->get_basename());
                $ob->ssend('当你下次连线进来时，会从这里开始。');
            }
        }
        
        if ($user->is_player()) {
            if ($user->save())
                $ob->ssend('档案储存完毕。');
            else
                $ob->ssend('储存失败。');
        }
        return true;
    }

    public function help() 
    {
        $ret = "指令格式：save<br>把你辛苦奋斗的结果存起来。";
        return $ret;
    }
}
