<?php
/**
*   樊夫人
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;
use \Workerman\Lib\Timer;

class wangfuren extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '樊夫人');
        $this->set('id', 'furen');
        $this->set('age', 52);
        $this->set('gender', '女性');
        $this->set("title", "HIR祭剑师NOR");
        $this->set('long', '樊夫人本是三清宫的一个老道士，人到老年无所事事，在这里给人祭剑。');
        $this->set('combat_exp', 50000);
        $this->set('str', 200);
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
                    msg::message_text('vision', '樊夫人笑道：这位' . $RANK_D->query_respect($me) . '，你的宝刃看起来好象要血祭(ji)一下了。', $this);
                    break;
                case 1:
                    msg::message_text('vision', '樊夫人说道：这位' . $RANK_D->query_respect($me) . '，你的宝刃杀气不足，来血祭(ji)一下宝刃吧。', $this);
                    break;
                default:
            }
            
        }
    }

    public function do_ji($ob, $arg)
    {
        $ob->ssend(OPENSOON);
        return true;
    }   
}
