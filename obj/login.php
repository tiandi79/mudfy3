<?php
/**
*  登录对象
*
*/
namespace obj;

use adm\daemons\logind;
use \Workerman\Lib\Timer;

class login
{
    private $timer_debug = false;
    /**
    *  param @ob 当前连接
    *  param @first 首次连接
    */
    function __construct($ob, $first = true) 
    {
        if ($first) {
            logind::login($ob);
            $ob->body = false;
        }
        $t = Timer::add(15, array($this, 'removelogin'), array($ob), false);  
        if ($this->timer_debug)
            echo "\nnew timer = ". $t;
        $ob->login_timer = $t;
    }

    public function removelogin($ob) 
    {
        if(!$ob->body)
            $ob->ssend("您花在连线进入手续的时间太久了，下次想好再来吧。");
        if (isset($ob->login_timer)) {
            if (Timer::del($ob->login_timer)) {
                if ($this->timer_debug)
                    echo "\nnow timer = ". $ob->login_timer . ' deleted';
                $ob->login_timer = null;
            }
        }
        global $GAME;
        $GAME->remove_login();
        $ob->destroy();
    }
}