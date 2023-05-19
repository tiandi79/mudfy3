<?php
/**
*   花柳毒
* 
*/
namespace daemon\condition;

use std\msg;

class hualiu
{
    function __construct()
    {
    }

    public function get_name()
    {
        return '花柳毒';
    }

    public function update_condition($me, $param)
    {
        $name = $param[0];
        $dur = $param[1];

        $limit = ($me->query('con') + $me->query('max_force') / 50) * 2;

        if ($dur > $limit) {
            $me->unconcious();
        } elseif ($dur > $limit / 2) {
            msg::message('vision', '$N觉得全身又痛又痒。', $me);
            $me->receive_damage("sen", 10);
        } elseif ($dur > $limit / 4) {
            msg::message('vision', '$N的花柳毒又发作了，满面痛苦后悔的表情。', $me);
            $me->receive_damage("sen", 10);
		    $me->receive_damage("gin", 10);
        }
        
        if ($dur > 0) {
            $nexttime = time() + 10;
            $param = array('hualiu', $dur - 1);
            $func = 'update_condition';
            $condition = array('next_time' => $nexttime, 'func' => $func, 'param' => $param, 'this_class' => $this);
            $me->apply_condition($condition);
        }
        return true;
    }
}
