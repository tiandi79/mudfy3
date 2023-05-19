<?php
/**
*  fingerd
*
*/
namespace adm\daemons;

use obj\user;

class fingerd
{
    function __construct() 
    {
    }

    public function finger_user($ob, $arg, $is_wiz)
    {
        $user = new user();
        $user->set('id', $arg);
        $file = $user->query_save_file($arg);
        if (!file_exists($file))
            return '没有这个玩家。';

        $data = file_get_contents($file);
        $data = unserialize($data);

        foreach ($data as $k => $v) {
            $user->$k = $v;
        }

        global $GAME;
        $msg = '';
        if ($is_wiz) {
            foreach ($GAME->users as $v) {
                if ($v->body->id == $user->id) {
                    $msg = $v->body->name . '目前正在从' . $v->getRemoteIp() . '连线中。'; 
                    break;
                }               
            }
            $msg .= "<br>英文ID：". $user->id . " 角色名称：" . $user->name . "<br>合计在线时间：". $this->age_string($user->mud_age);  
        } else {
            foreach ($GAME->users as $v) {
                if ($v->body->id == $user->id) {
                    $msg = $v->body->name . '目前正在连线中。'; 
                    break;
                }               
            }
            $msg .= "<br>英文ID：". $user->id . " 角色名称：" . $user->name . "<br>合计在线时间：". $this->age_string($user->mud_age);  
        }
        $user->destruct();
        return $msg;
    }

    private function age_string($mud_age)
    {
        $mud_age /= 60;
        $minute = intval($mud_age % 60);
        $mud_age /= 60;
	    $hour = intval($mud_age % 24);
	    $mud_age /= 24;
	    $day = intval($mud_age % 30);
	    $month = intval($mud_age / 30);
	    return ($month ? $month . "月" : "") . ($day ? $day . "天" : "") . $hour . "小时" . $minute . "分钟";
    }
}
