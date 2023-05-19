<?php
/**
*  买
*
*/
namespace cmds\std;

use std\msg;

class buy
{
    function __construct()
    {
    }

    public function do_cmd($ob, $item = null, $from = 'from', $name = null)
    {
        $me = $ob->body;

        if (!isset($item) || !isset($from) || !isset($name) || $from != 'from') {
            $ob->ssend('指令格式：buy <物品> from <某人>');
            return false;
        }

        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成！');
            return false;
        }

        if (!$who = $me->is_environment($name)) {
            $ob->ssend('你要跟谁买东西？');
            return false;
        }

        if ($who->is_player()) {
            msg::message('vision', '$N想向$n购买「' . $item . '」。', $me, $who);
            return false;
        }

        if (($price = $who->buy_object($me, $item)) < 1) {
	        $ob->ssend("对方好像没有你想要的东西。");
            return false;
        }

        if ($afford = $this->affordable($me, $price)) {
		    $this->pay_him($me, $afford - $price);
		    $who->compelete_trade($me, $item);
		    $who->add("richness", $price);
	    } else {
		    $ob->ssend('你的钱不够。');
        }
	    $me->start_busy(1);
        return true;
    }

    public function help() 
    {
        $ret = "指令格式: buy <物品> from <某人><br>这一指令让你可以从某些人身上买到物品。";
        return $ret;
    }

    private function affordable($me, $amount)
    {
        $tencash = $me->is_carry('tenthousand-cash');
        $cash = $me->is_carry('thousand-cash');
        $gold = $me->is_carry('gold');
        $silver = $me->is_carry('silver');
        $coin = $me->is_carry('coin');

        $total = 0;
        if ($tencash) 
            $total += $tencash->query('value');
        if ($cash)
            $total += $cash->query('value');
        if ($gold) 
            $total += $gold->query('value');
        if ($silver)
            $total += $silver->query('value');
        if ($coin) 
            $total += $coin->query('value');

        if ($total < $amount ) 
            return 0;
        else
            return $total;
    }

    private function pay_him($me, $amount)
    {
        $tencash = $me->is_carry('tenthousand-cash');
        $cash = $me->is_carry('thousand-cash');
        $gold = $me->is_carry('gold');
        $silver = $me->is_carry('silver');
        $coin = $me->is_carry('coin');

        if ($tencash)
            $tencash->destruct();
        if ($cash)
            $cash->destruct();
        if ($gold)
            $gold->destruct();
        if ($silver)
            $silver->destruct();
        if ($coin)
            $coin->destruct();

        if ($amount < 0)
            return false;
        global $OBJECT;

        if ($i = intval($amount / 1000000)) {
            $obj = $OBJECT->create_objects('/obj/money/tenthousandcash');
            $obj->set_amount($i);
            $obj->move($me);
            $amount %= 1000000;
        }
        if ($i = intval($amount / 100000)) {
            $obj = $OBJECT->create_objects('/obj/money/thousandcash');
            $obj->set_amount($i);
            $obj->move($me);
            $amount %= 100000;
        }
	    if ($i = intval($amount / 10000)) {
            $obj = $OBJECT->create_objects('/obj/money/gold');
            $obj->set_amount($i);
            $obj->move($me);
            $amount %= 10000;
        }
        if ($i = intval($amount / 100)) {
            $obj = $OBJECT->create_objects('/obj/money/silver');
            $obj->set_amount($i);
            $obj->move($me);
            $amount %= 100;
        }
        if ($i = intval($amount)) {
            $obj = $OBJECT->create_objects('/obj/money/coin');
            $obj->set_amount($i);
            $obj->move($me);
        } 
    }
}
