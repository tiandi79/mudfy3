<?php
/**
*   孟婆
*
*/
namespace d\death\npc;

use std\msg;
use std\char;

class mengpo extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '孟婆');
        $this->set('id', 'mengpo');
        $this->set('gender', '女性');
        $this->set('age', 220);
        $this->set('long', '据说孟婆追随老伴到地府之后，因生活无着落，人心甚好，所以阎王特准她在这里做点生意，因为孟婆汤（ｓｏｕｐ）好，所以以卖汤为生，
后阎王传其一方，可以使人忘却地狱的苦痛，于是孟婆的生意便一日好过一日。投生的人都爱在此买一碗后走上轮回之路。');
        $this->set("intellgent",1);
        $this->set("attitude", "peaceful");
        $this->set("chat_chance", 1);
        $this->set('chat_msg', array('孟婆对你说：＂在下面受了不少苦吧，来碗汤吧！＂', '孟婆说：＂孩子，上路前喝一碗吧！'));
        $this->set("combat_exp", 5000);
        $this->set_temp("apply/astral_vision", 1);
        $this->equip_object('/obj/obj/cloth');
        $this->set('inquiry', array('孟婆汤' => ':give_soup', 'soup' => ':give_soup' , 'xxx' => 'xxx'));
        $this->add_money('silver', 5);
        $this->set_temp('gived', 0);
    }

    public function accept_object($me, $ob)
    {
        msg::message('vision', '$N对$n怪叫一声：在阳间做亏心事了吧！', $this, $me);
        return true;
    }

    public function give_soup($me)
    {
        if ($this->query_temp('gived') == 1) {
            msg::message_text('say', '唉呦！刚刚卖光，你等着，我就去再熬一锅！', $this);
            return true;
        } else {
            msg::message('vision', '$N以熟练的手法舀起一碗汤递给$n。', $this, $me);
            msg::message_text('say', '别厌弃，快点儿喝，喝完好上路！', $this);
            global $OBJECT;
            $obj = $OBJECT->create_objects('/d/death/npc/obj/dang');
            $obj->move($me);
            if (rand(0, 10) == 0)
                $this->set_temp('gived', 1);
            return true;
        }
    }
}
