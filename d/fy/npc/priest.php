<?php
/**
*   priest
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;
use \Workerman\Lib\Timer;

class priest extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '教父');
        $this->set('id', 'priest');
        $this->set('gender', '男性' );
        $this->set('age', 74);
        $this->set('long','这位店小二正笑咪咪地忙著，还不时拿起挂在脖子上的抹布擦脸。');
        $this->set('combat_exp', 1);
        $this->set('attitude', 'friendly');
    }

    public function init_coming($me)
    {
        if (!$this->is_fighting())
            $this->call_out(1, 'greating', $me);
    }

    public function greating($me)
    {
        $this->timerid = null;
        if ($me->is_player() && $this->is_environment($me->query('id'))) {
            global $RANK_D;
            msg::message_text('say', '这位' . $RANK_D->query_respect($me) . '，主会保佑你的。', $this);
        }
    }
}
