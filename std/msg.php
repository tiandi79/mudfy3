<?php
/**
*  信息类基础
*
*/

namespace std;

class msg
{
    function __construct() 
    {

    }

    /* 将频道集成于此 */
    public static function channel($type, $message, $ob)
    {   
        $me = $ob->body;

        if ($me->is_player() && !$me->wizardp() && $me->query("mud_age") < NEW_PERIOD && ($type == 'fy' || $type == 'chat' || $type == 'rumor')) {
            $ob->ssend('你只可以使用【新手】（new）频道。');
            return true; 
        }
        if (!$me->wizardp() && $type == 'wiz') {
            $ob->ssend('玩家不可以使用【巫师】（wiz）频道。');
            return true; 
        }
        if (!$me->wizardp() && $type == 'sys') {
            $ob->ssend('玩家不可以使用【系统】（sys）频道。');
            return true; 
        }
        global $GAME;
        foreach ($GAME->users as $v) {
            if ($type == 'rumor')
                $v->ssend('HIM【谣言】某人：' . $message . 'NOR');
            elseif ($type == 'new') 
                $v->ssend('HIG【新手】' . $me->name . '(' . $me->id . ')：' . $message . 'NOR');
            elseif ($type == 'chat') 
                $v->ssend('HIC【闲聊】' . $me->name . '(' . $me->id . ')：' . $message . 'NOR');
            elseif ($type == 'fy') 
                $v->ssend('HIR【风云】' . $me->name . '(' . $me->id . ')：' . $message . 'NOR');
            elseif ($type == 'wiz') 
                $v->ssend('HIY【巫师】' . $me->name . '(' . $me->id . ')：' . $message . 'NOR');
            elseif ($type == 'sys') 
                $v->ssend('HIR【系统】' . $message . 'NOR');
        }
        return true;
    }
    
    /* 向物件所在场景的所有用户推送文本信息 */
    public static function message_text($type, $message, $obj)
    {
        /* 只允许对象物件当前有场景的情况 */
        if (isset($obj->place)) {
            $room = $obj->place;
            $objs = null;

            if (null !== ($room->all_inventory())) {
                $objs = $room->all_inventory();
            }
            
            if ($type == 'say')
                $message = 'CYN' . $obj->name . '说道：' . $message . 'NOR';

            foreach ($objs as $k => $v) {
                if ($v->is_player() && $v->query_temp('block_msg/all') == null) {
                    $v->get_conn()->ssend($message);
                }
            }
        }           
    }

    /* 向物件所在场景的所有用户推送信息，信息包含代词 */
    public static function message($type, $message, $me, $obj = null)
    {
        /* 只允许对象物件当前有场景的情况 */
        if (isset($me->place) || $me->type == 'room') {            
            if ($me->type == 'room')
                $room = $me;
            else
                $room = $me->place;
            $objs = null;

            if (null !== ($room->all_inventory())) {
                $objs = $room->all_inventory();
            }

            foreach ($objs as $k => $v) {
                if ($v->is_player() && $v->query_temp('block_msg/all') == null) {
                    
                    if ($v == $me) {
                        $me_pro = $me->query('gender') == '男性' ? '你' : '妳';
                        $msg = str_replace('$N', $me_pro, $message);
                        if (isset($obj)) {
                            $msg = str_replace('$n', $obj->query('name'), $msg);        
                            $gender = $obj->query('gender') == '男性' ? '他' : '她';
                            $msg = str_replace('$p', $gender, $msg);
                        }                      
                    }
                    elseif (isset($obj) && $v == $obj) {
                        $obj_pro = $obj->query('gender') == '男性' ? '你' : '妳';
                        $msg = str_replace('$N', $me->query('name'), $message);
                        $msg = str_replace('$n', $obj_pro, $msg);
                        $msg = str_replace('$p', $obj_pro, $msg);
                    }
                    else {
                        $msg = str_replace('$N', $me->query('name'), $message);
                        if (isset($obj)) {
                            $msg = str_replace('$n', $obj->query('name'), $msg);
                            $gender = $obj->query('gender') == '男性' ? '他' : '她';
                            $msg = str_replace('$p', $gender, $msg);
                        }
                    }
                    /*if (null != $obj->query_temp('weapon')) {
                        $weapon = $obj->query_temp('weapon');
                        $msg = str_replace('$p', $weapon->query('name'), $msg);
                    }
                    if (null != $me->query_temp('weapon')) {
                        $weapon = $me->query_temp('weapon');
                        $msg = str_replace('$w', $weapon->query('name'), $msg);
                    }       */
                    $v->get_conn()->ssend($msg);
                }
            }
        }           
    }
}
