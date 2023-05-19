<?php
/**
*  显示所有物件信息
*
*/

namespace cmds\wiz;

class uids
{
    function __construct() 
    {

    }

    public function do_cmd($ob) 
    {
        global $GAME;

        if (!$ob->body->wizardp()) {
            $ob->ssend("什么？");
            return;
        }

        $objects = $GAME->users;
        $ob->ssend('当前可用UID为' . $GAME->uid);
        $ob->ssend('--------------------------------');
        foreach ($objects as $k => $v) {           
            if (!isset($v->body->name))
                $name = '未命名物件';
            else
                $name = $v->body->name;

            if (!isset($v->body->id))
                $id = '未命名物件';
            else
                $id = $v->body->id;

            $ob->ssend('UID :' . $v->uid. ' CONN ID :' . $v->id . ' ID :' . $id . ' NAME :' . $name);
        }
    }

    public function help() 
    {
        $ret = "指令格式 : uids<br>这个指令告诉目前系统内存中的用户物件信息.";
        return $ret;
    }
}
