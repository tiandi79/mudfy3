<?php
/**
*   牛皮酒袋
*
*/
namespace d\death\npc\obj;

use std\msg;
use std\liquid;

class wineskin extends liquid
{
    public $revive_loc = array('d/fy/church');
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'jiudai');
        $this->set('name', '牛皮酒袋');
        $this->set('value', 20);
        $this->set('unit', '个');
        $this->set('long', '一个牛皮缝的大酒袋。');
		$this->set("max_liquid", 15);
        $this->set("liquid", array("type" => "alcohol", "name" => "还阳酒", "remaining" => 5, "drunk_apply" => 6));
        $this->set_weight(700);
    }

    function do_drink($ob, $arg = null)
    {
        if ($arg == null) {
            $ob->ssend('你要吃什么？');
            return true;
        }

        if ($arg != $this->query('id')) {
            return false;
        }

        $me = $ob->body;
        
        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成。');
            return true;
        }

        $me->start_busy(1);
        $liquid = $this->query('liquid');

        if ($liquid['remaining'] == 0) {
            $ob->ssend($this->query('name') . (isset($liquid['name']) ? '已经被喝得一滴也不剩了。' : '是空的。'));
            return true;
        }

        if ($me->query('water') >= $me->max_water_capacity()) {
            $ob->ssend('你已经喝太多了，再也灌不下一滴水了。');
            return true;
        }

        $remain = $liquid['remaining'] * 30;
        $avai = $me->max_water_capacity() - $me->query('water');
        if ($remain > $avai) {
            $me->add('water', $avai);
            $liquid['remaining'] -= intval($avai / 30);
            $this->set('liquid', $liquid);
        } else {
            $me->add('water', $remain);
            $liquid['remaining'] = 0;
            $this->set('liquid', $liquid);
        }

        if ($me->is_fighting())
            $me->start_busy(2);

        msg::message('vision', '$N拿起' . $this->query('name') . '咕噜噜地喝了几口' . $liquid['name'] . '。', $me);

        if ($liquid['remaining'] == 0)
            $ob->ssend('你已经将' . $this->query('name') . '里的' . $liquid['name'] . '喝得一滴也不剩了。');

        if ($liquid['type'] == 'alcohol') {
            $nexttime = time() + 10;
            $param = array('drunk', $liquid['drunk_apply']);
            $func = 'update_condition';
            global $CONDITIONS;
            $this_class = $CONDITIONS->get('drunk');
            $condition = array('next_time' => $nexttime, 'func' => $func, 'param' => $param, 'this_class' => $this_class);
            $me->apply_condition($condition);
        }

        if ($me->is_ghost()) {
            $me->is_ghost = false;
            $me->set('eff_gin', $me->query('max_gin'));
            $me->set('eff_kee', $me->query('max_kee'));
            $me->set('eff_sen', $me->query('max_sen'));

            global $OBJECT;
            $room = $OBJECT->get_room($this->revive_loc[rand(0, count($this->revive_loc) - 1)]);
            $me->move($room, true);
            $env = $me->get_env();

            $me->set('startroom', $env->id);
            $me->save();
            msg::message_text('vision', '你忽然发现前面多了一个人影，不过那人影又好像已经在那里很久了，只是你一直没发觉。', $me);
            return true;
        }
        return true;
    }
}
