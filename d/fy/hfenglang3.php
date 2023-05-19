<?php
/**
*  长廊
*
*/
namespace d\fy;

use std\msg;
use std\room;

class hfenglang3 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '长廊');
        $this->set('long', '这里是给到这儿的小姐们更衣入浴的，地上是五光十色的彩带和香味扑鼻的花瓣,昂贵的衣裳满地都是，透过蒙蒙水雾，你可以看到白腻的身躯，修长的大腿，坚挺的胸膛，和乌黑的长发。。。。。。');
        $this->set('exits', array("west" => "fy/hfenglang2",
                             "east" => "fy/hfengpool"));
        $this->set('objects', array("fy/npc/smileboy" => 1));
        $this->set('coor/x', 31);
        $this->set('coor/y', 40);
        $this->set('coor/z', 0);
        $this->set("no_fight",1);
	    $this->set("no_magic",1);

        parent::setup_room();
    }

    public function valid_leave($me, $dir)
    {
        $ob = $me->get_conn();
        if ($dir == 'east' && $target = $me->is_environment('jintong')) {
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

        if ($dir == 'west' && $target = $me->is_environment('jintong')) {
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
