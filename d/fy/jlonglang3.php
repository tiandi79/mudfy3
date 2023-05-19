<?php
/**
*  走廊
*
*/
namespace d\fy;

use std\msg;
use std\room;

class jlonglang3 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '走廊');
        $this->set('long', '一人多高，只容两人并行的檀香木走廊，廊中的两侧陈列着一些奇花异草。滚滚热气从走廊的一头冒出，将檀木地板打得又湿又滑，你几乎要扶着栏杆才不会滑倒。');
        $this->set('exits', array("east" => "fy/jlonglang2",
                             "west" => "fy/jlongpool"));
        $this->set('objects', array("fy/npc/smilegirl" => 1));
        $this->set('coor/x', -30);
        $this->set('coor/y', 40);
        $this->set('coor/z', 0);
        $this->set("no_fight",1);
	    $this->set("no_magic",1);

        parent::setup_room();
    }

    public function valid_leave($me, $dir)
    {
        $ob = $me->get_conn();
        if ($dir == 'west' && $target = $me->is_environment('chuchu')) {
            $whitetowel = 0;
            $inv = $me->all_inventory();
            foreach($inv as $v) {
                if ($v->query('id') != 'whitetowel') {
                    $ob->ssend($target->query('name') . '向你笑道：身上穿戴那么多，怎么能洗澡？');
                    return false;
                } elseif ($v->query('id') == 'whitetowel') {
                    $whitetowel = 1;
                    if ($v->query('equipped') == null) {
                        $ob->ssend($target->query('name') . '向你笑道：还是围上毛巾再进去吧，不要吓到别人。');
                        return false;
                    }
                }
            }

            if ($whitetowel == 0) {
                $ob->ssend($target->query('name') . '向你笑道：没有白毛巾怎么洗？');
                return false;
            }
        }

        if ($dir == 'east' && $target = $me->is_environment('chuchu')) {
            $inv = $me->all_inventory();
            foreach($inv as $v) {
                if ($v->query('id') == 'whitetowel') {
                    $ob->ssend($target->query('name') . '笑咪咪的将你身上湿的' . $v->query('name') . '拿了回去。');
                    $v->destruct();
                }
            }
        }
        return true;
    }
}
