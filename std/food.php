<?php
/**
*   食物类
*
*/
namespace std;

use std\msg;

class food extends obj
{
    function __construct()
    {
        parent::__construct();
        $this->type = 'food';
    }

    function do_eat($ob, $arg = null)
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

        if ($this->query('food_remaining') == 0) {
            $ob->ssend($this->query('name') . '已经没什麽好吃的了。');
            return true;
        }

        if ($me->query('food') >= $me->max_food_capacity()) {
            $ob->ssend('你已经吃太饱了，再也塞不下任何东西了。');
            return true;
        }

        $remain = $this->query('food_remaining') * $this->query('food_supply');
        $avai = $me->max_food_capacity() - $me->query('food');
        if ($remain > $avai) {
            $me->add('food', $avai);
            $this->add('food_remaining', - intval($avai / $this->query("food_supply")));
        } else {
            $me->add('food', $remain);
            $this->set('food_remaining', 0);
        }

        if ($me->is_fighting())
            $me->start_busy(2);

        if (method_exists($this, "eat_func")) {
            $this->eat_func();               
        }

        $this->set('value', 0);
        if ($this->query('food_remaining') == 0) {
            msg::message('vision', '$N将剩下的' . $this->query('name') . '吃得乾乾净净。', $me);
            if (method_exists($this, "finish_eat"))
                $this->finish_eat();
            else
                $this->destruct();
        }
        else {
            msg::message('vision', '$N拿起' . $this->query('name') . '咬了几口。', $me);
        }
        return true;
    }
}
