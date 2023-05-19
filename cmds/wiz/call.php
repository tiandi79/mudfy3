<?php
/**
*  call
*  
*/
namespace cmds\wiz;

use std\msg;

class call
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

        if (null == $arg)
            $ob->ssend("指令格式: call <参数>");
        else {
            $me = $ob->body;
            $i = strpos($arg, '->');
            $objid = substr($arg, 0, $i);
            if (!$me->is_environment($objid) && !$me->is_carry($objid))
                $ob->ssend("找不到这个生物。");
            else {
                $obj = $me->is_environment($objid);
                if (!$obj)
                    $obj = $me->is_carry($objid);

                if (strpos($arg, 'set_temp')) {
                    $cmd = substr($arg, $i +  11);
                    $cmd = substr($cmd, 0, -1);
                    $cmds = explode(',', $cmd);
                    if ($cmds[1] == 'false')
                        $cmds[1] = false;
                    if ($cmds[1] == 'true')
                        $cmds[1] = true;
                    $obj->set_temp($cmds[0], $cmds[1]);
                    $ob->ssend("\n物件#" . $obj->name . $arg ." OK.");
                } elseif (strpos($arg, 'query_temp')) {
                    $cmd = substr($arg, $i +  13);
                    $cmd = substr($cmd, 0, -1);
                    $r = $obj->query_temp($cmd);
                    if (is_string($r) || is_numeric($r))
                        $ob->ssend("\n物件#" . $obj->name . $arg ." => " . $r);
                    else
                        $ob->ssend('不能显示物件的对象属性。');
                } elseif (strpos($arg, 'set_amount')) {
                    $cmd = substr($arg, $i +  13);
                    $cmd = substr($cmd, 0, -1);
                    $obj->set_amount($cmd);
                    $ob->ssend("\n物件#" . $obj->name . $arg ." OK.");
                } elseif (strpos($arg, 'set_skill')) {
                    $cmd = substr($arg, $i +  12);
                    $cmd = substr($cmd, 0, -1);
                    $cmds = explode(',', $cmd);
                    if ($cmds[1] !=  0)
                        $obj->set_skill($cmds[0], intval($cmds[1]));
                    else
                        $obj->del_skill($cmds[0]);
                    $ob->ssend("\n物件#" . $obj->name . $arg ." OK.");
                } elseif (strpos($arg, 'set_marks')) {
                    $cmd = substr($arg, $i +  12);
                    $cmd = substr($cmd, 0, -1);
                    $cmds = explode(',', $cmd);
                    if ($cmds[1] != 'null')
                        $obj->setmarks($cmds[0], $cmds[1]);
                    else
                        $obj->delmarks($cmds[0]);
                    $ob->ssend("\n物件#" . $obj->name . $arg ." OK.");
                }elseif (strpos($arg, 'set')) {
                    $cmd = substr($arg, $i +  6);
                    $cmd = substr($cmd, 0, -1);
                    $cmds = explode(',', $cmd);
                    if ($cmds[1] == 'false')
                        $cmds[1] = false;
                    if ($cmds[1] == 'true')
                        $cmds[1] = true;
                    $obj->set($cmds[0], $cmds[1]);
                    $ob->ssend("\n物件#" . $obj->name . $arg ." OK.");
                }
                elseif (strpos($arg, 'query')) {
                    $cmd = substr($arg, $i +  8);
                    $cmd = substr($cmd, 0, -1);
                    $r = $obj->query($cmd);
                    if (is_string($r) || is_numeric($r))
                        $ob->ssend("\n物件#" . $obj->name . $arg ." => " . $r);
                    else
                        $ob->ssend('不能显示物件的对象属性。');
                }
                else
                    $ob->ssend($arg ." Failed.");
            }
        }
    }

    public function help() 
    {
        $ret = "指令格式: call <参数>";
        return $ret;
    }
}