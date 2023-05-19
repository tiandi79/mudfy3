<?php
/**
*  goto
*  
*/
namespace cmds\wiz;

use std\msg;

class ggoto
{
    function __construct() 
    {

    }

    public function do_cmd($ob, $arg = null) 
    {
        global $OBJECT;
        if (!$ob->body->wizardp()) {
            $ob->ssend("什么？");
            return;
        }

        if (null == $arg) {
            $ob->ssend("指令格式: ggoto <物件>");
            return;
        }

        $me = $ob->body;

        foreach ($OBJECT->_objs as $k => $v) {
            if ($v->id == $arg) {
                /* 移动到物件的场景 */
                if (isset($v->place)) 
                    $room = $OBJECT->get_room($v->place->id);                  
                else
                    $room = $OBJECT->get_room($v->id);

                
                if (isset($room)) {
                    msg::message('vision', '你眼前一花，$N的身影已经不见了。', $me);
                    $me->move($room);
                    msg::message('vision', '你眼前一花，$N的身影出现在面前。', $me);
                    return true;
                }
                else {
                    $ob->ssend('你不能移动到此场景。');
                    return false;
                }
            }
        }
        $file = ROOT_DIR . $arg .'.php';
        if (file_exists($file)) {
            $room = $OBJECT->get_room($arg);
            if (isset($room)) {
                msg::message('vision', '你眼前一花，$N的身影已经不见了。', $me);
                $me->move($room);
                msg::message('vision', '你眼前一花，$N的身影出现在面前。', $me);
                return true;
            }
        }
        $ob->ssend('找不到该物件。');
    }

    public function help() 
    {
        $ret = "指令格式: ggoto <物件>移动到该物件位置。";
        return $ret;
    }
}