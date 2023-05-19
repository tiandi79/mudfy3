<?php
/**
*  summon
*  
*/
namespace cmds\wiz;

use std\msg;

class summon
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

        if (null == $arg)
            $ob->ssend("指令格式: summon <某人>");
        else {
            global $OBJECT;
            $objs = $OBJECT->_objs;
            foreach ($objs as $v) {
                if ($v->id == $arg) {
                    msg::message('vision', '天空中伸出一只大手把$N抓了起来, 然後不见了。', $v);
                    if ($v->move($me->get_env())) {
                        msg::message('vision', '$N把$n抓到面前。。。', $me, $v);
                        return true;
                    }    
                }
            }
            $ob->ssend('咦... 有这个人吗?');
        }
    }

    public function help() 
    {
        $ret = "指令格式 : summon <某人>此指令可让你(□)将某人抓到你面前。";
        return $ret;
    }
}