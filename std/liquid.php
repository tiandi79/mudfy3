<?php
/**
*   容器类
*
*/
namespace std;

use std\msg;

class liquid extends obj
{
    function __construct()
    {
        parent::__construct();
        $this->type = 'liquid';
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

        if (method_exists($this, "drink_func")) {
            $this->drink_func();               
        }

        if ($liquid['type'] == 'alcohol') {
            //me->apply_condition("drunk", $me->query_condition("drunk") + $liquid['drunk_apply']);
        }
        return true;
    }
}
