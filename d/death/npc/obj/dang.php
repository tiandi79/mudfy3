<?php
/**
*   大海碗
*
*/
namespace d\death\npc\obj;

use std\msg;
use std\liquid;

class dang extends liquid
{
    public $revive_loc = array('d/fy/church');
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'aiwan');
        $this->set('name', '大海碗');
        $this->set('weight', 700);
        $this->set('value', 20);
        $this->set('unit', '个');
        $this->set('long', '一个青瓷大海碗。');
		$this->set("max_liquid", 15);
        $this->set("liquid", array("type" => "alcohol", "name" => "孟婆汤", "remaining" => 5, "drunk_apply" => 6));
    }

    function do_drink($ob, $arg = null)
    {
        parent::do_drink($ob, $arg);
        $me = $ob->body;
        if ($me->is_ghost()) {
            $me->is_ghost = false;
            $me->set('eff_gin', $me->query('max_gin'));
            $me->set('eff_kee', $me->query('max_kee'));
            $me->set('eff_sen', $me->query('max_sen'));
            $me->unconcious();
            global $OBJECT;
            $room = $OBJECT->get_room($this->revive_loc[rand(0, count($this->revive_loc) - 1)]);
            $me->move($room, true);
            $env = $me->get_env();

            $me->set('startroom', $env->id);
            $me->save();
            msg::message_text('vision', '你忽然发现前面多了一个人影，不过那人影又好像已经在那里很久了，只是你一直没发觉。', $me);
            return true;
        }
    }
}
