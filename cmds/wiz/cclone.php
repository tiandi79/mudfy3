<?php
/**
*  克隆
*
*/

namespace cmds\wiz;

use std\msg;

class cclone
{
    function __construct() 
    {

    }

    public function do_cmd($ob, $arg = null) 
    {
        $me = $ob->body;
        if (!$me->wizardp()) {
            $ob->ssend("什么？");
            return;
        }

        if (!isset($arg)) {
            $ob->ssend("指令格式: update <物件>");
        }
        else {
            $file = ROOT_DIR . $arg .'.php';
            if (!file_exists($file)) {
                $ob->ssend('没有这个物件文档。');
                return null;
            } else {
                $arg = str_replace('/', '\\', $arg);
                global $OBJECT;
                $obj = $OBJECT->create_objects($arg);
                if ($obj->type == 'room') {
                    $obj->destruct();
                    $ob->ssend('不能克隆这个物件。');
                } else {
                    if ($obj->is_character())
                        $obj->move($me->get_env());
                    else
                        $obj->move($me);
                    msg::message('vision', '$N在怀中摸索一番，拿出了$n。', $me, $obj);
                }
            }
        }
    }

    public function help() 
    {
        $ret = "指令格式 : clone <物件><br>利用此指令可复制一个物件.";
        return $ret;
    }
}
