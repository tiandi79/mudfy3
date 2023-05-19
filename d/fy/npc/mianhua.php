<?php
/**
*   老板娘
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;
use \Workerman\Lib\Timer;

class mianhua extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '老板娘');
        $this->set('id', 'boss');
        $this->set('age', 52);
        $this->set('gender', '女性');
        $this->set('long', '老板娘善长补衣服，补出来的衣服又牢固而且不难看。');
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
                    msg::message_text('vision', '老板娘笑道：这位' . $RANK_D->query_respect($me) . '，你的衣衫看起来好象要补(bu)一下了。', $this);
                    break;
                case 1:
                    msg::message_text('vision', '老板娘说道：这位' . $RANK_D->query_respect($me) . '，你的衣衫都被人砍破了，来补(bu)一下吧。', $this);
                    break;
                default:
            }
            
        }
    }

    public function do_bu($ob, $arg)
    {
        $ob->ssend(OPENSOON);
        return true;
    }   
}
