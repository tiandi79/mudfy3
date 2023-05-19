<?php
/**
*   醉酒
* 
*/
namespace daemon\condition;

use std\msg;

class drunk
{
    function __construct()
    {
    }

    public function get_name()
    {
        return '醉酒';
    }

    public function update_condition($me, $param)
    {
        $name = $param[0];
        $dur = $param[1];

        $limit = $me->query('con') * 2;
        if ($dur > $limit) {
            $me->unconcious();
        } elseif ($dur > $limit / 2) {
            msg::message('vision', '$N摇头晃脑地站都站不稳，显然是喝醉了。', $me);
            $me->receive_damage("sen", 10);
        } elseif ($dur > $limit / 4) {
            msg::message('vision', '$N脸上已经略显酒意了。', $me);
            $me->receive_damage("sen", 10);
		    $me->receive_damage("gin", 10);
        }
        
        if ($dur > 0) {
            $nexttime = time() + 10;
            $param = array('drunk', $dur - 1);
            $func = 'update_condition';
            $condition = array('next_time' => $nexttime, 'func' => $func, 'param' => $param, 'this_class' => $this);
            $me->apply_condition($condition);
        }
        return true;
    }
}
