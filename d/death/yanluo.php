<?php
/**
*  阎罗殿
*
*/
namespace d\death;

use std\msg;
use std\room;

class yanluo extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '阎罗殿');
        $this->set('long', '经过一路走来的黑暗，乍进门来，牛油巨烛耀眼的光芒让你一阵炫晕，定下神来，鎏金镶玉的王座上端坐着一位黑面君王，正是掌握六道轮回，
万物来世的阎罗王。两侧四名判官，各捧生死簿册，牛头，马面，各拿武器，横眉怒目，当堂责罚人犯。世上一切蠃虫，羽虫，毛虫，鳞介无不由此受判。');

        $this->set('objects', array("death/npc/yanwang" => 1,
            'death/npc/panguan' => 2,
            'death/npc/niutou' => 2,
            'death/npc/mamian' => 2));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -30);
        $this->set('coor/z', -100);
        $this->set('no_dazuo', 1);
        $this->set('no_fight', 1);

        parent::setup_room();
    }

    public function init_coming($me)
    {
        $me->call_out(15, 'letgo', $me, $this);
    }

    public function letgo($param)
    {
        $me = $param[0];
        if ($me->get_env() == $this) {
            msg::message('vision', '阎王爷长叹一口气：＂算了，算了，让$N四处逛逛，知道这里是赏罚分明，只要$N来世再也不敢胡作非为就可以了！<br><br>一阵冷风吹散了$N的阴魂．．．＂', $me);
            global $OBJECT;
            $room = $OBJECT->get_room('d/death/dizang');
            $me->move($room);
        }
    }
}
