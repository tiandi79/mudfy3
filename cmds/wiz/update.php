<?php
/**
*  update
*  
*/
namespace cmds\wiz;

use std\msg;

class update
{
    function __construct() 
    {

    }

    public function do_cmd($ob, $arg = null) 
    {
        if (!$ob->body->wizardp()) {
            $ob->ssend("什么？");
            return;
        }

        global $OBJECT;
        if (null == $arg)
            $ob->ssend("指令格式: update <物件>");
        elseif ($arg == 'here') {       
            $OBJECT->update_room($ob->body->get_env()->id);
            $ob->ssend('当前场景更新完毕。');
        } else {
            $file = ROOT_DIR . $arg .'.php';
            if (!file_exists($file)) {
                $ob->ssend('没有这个物件文档。');
                return null;
            } else {
                $arg = str_replace('/', '\\', $arg);
                $OBJECT->update_room($arg);
                $ob->ssend('指定场景更新完毕。');
            }
        }
    }

    public function help() 
    {
        $ret = "指令格式: update <物件>初始化物件信息";
        return $ret;
    }
}