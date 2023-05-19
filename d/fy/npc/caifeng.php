<?php
/**
*   老裁缝
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;
use \Workerman\Lib\Timer;

class caifeng extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '老裁缝');
        $this->set('id', 'waiter');
        $this->set('age', 52);
        $this->set('gender', '男性');
        $this->set('long', '这位老裁缝正笑咪咪地忙著，还不时的擦一擦自己的老花眼。');
        $this->set('combat_exp', 5);
        $this->set("attitude", "friendly");
        $this->equip_object('/obj/obj/cloth');
    }

    public function init_coming($me)
    {
        if (!$this->is_fighting()) {
            $this->call_out(1, 'greating', $me);
        }
    }

    public function greating($me)
    {
        $this->timerid = null;
        if ($me->is_player() && $this->is_environment($me->query('id'))) {
            global $RANK_D;
            $i = rand(0,5);
            switch($i) {
                case 0:
                    msg::message_text('vision', '老裁缝笑咪咪地说道：这位' . $RANK_D->query_respect($me) . '，进来订身衣服吧。', $this);
                    break;
                case 1:
                    msg::message_text('vision', '老裁缝愁眉苦脸说道：这位' . $RANK_D->query_respect($me) . '，你又胖又矮，这帮不了你。', $this);
                    break;
                default:
            }
            
        }
    }

    public function do_ding($ob, $arg)
    {
        $ob->ssend(OPENSOON);
        return true;
    }   
}
