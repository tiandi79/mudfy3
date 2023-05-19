<?php
/**
*  银行老板定义
*
*/

namespace std;

class bankowner extends char
{      
    function __construct() 
    {
        parent::__construct();
    }

    public function do_deposit($ob, $amount = null, $type = null)
    {
        $me = $ob->body;
        if ($me->is_busy()) {
            $ob->ssend('你的动作还没有完成，不能兑存钱。');
            return true;
        }

        if ($amount == null || !is_numeric($amount) || $type == null) {
            $ob->ssend('指令格式：deposit <数量> <货币种类>');
            return true;
        }

        $money = $me->is_carry($type);
        if (null == $money) {
            $ob->ssend('你身上没有这种货币。');
            return true;
        }

        if ($money->query('type') != 'money') {
            $ob->ssend('你只能存钱。');
            return true;
        }

        if ($money->query_amount() < $amount) {
            $ob->ssend('你身上没有那麽多' . $money->query('name'));
            return true;
        }

        $balance = $me->query('balance');
        $deposit_amount = $amount * $money->query('base_value');
        $balance += $deposit_amount;
        $this->add('richness', $deposit_amount);
        $me->set('balance', $balance);
        $money->add_amount(-$deposit_amount);
        global $CHINESE_D;
        msg::message('vision', '$N存入了' . $CHINESE_D->chinese_number($amount) . $money->query('base_unit') . $money->query('name') . '。', $me);
        $me->start_busy(1);
        return true;
    }

    public function do_balance($ob, $arg = null)
    {
        $me = $ob->body;
        if ($me->is_busy()) {
            $ob->ssend('你的动作还没有完成，不能兑存钱。');
            return true;
        }

        $value = $me->query('balance');
        if ($value == null || $value == 0) {
            $ob->ssend('你现在没有存款。');
            return true;
        }
        global $CHINESE_D;
        if ($value < 100)
		    $ob->ssend('你现在共有存款：<br>' . $CHINESE_D->chinese_number($value) . '文钱。');
        else
			$ob->ssend('你现在共有存款：<br>' . $CHINESE_D->chinese_number($value / 100) . '两' . ($value % 100 ? '又' . $CHINESE_D->chinese_number($value % 100) . '文钱。':''));
        return true;
    }

    public function do_withdraw($ob, $amount = null)
    {
        $me = $ob->body;
        if ($me->is_busy()) {
            $ob->ssend('你的动作还没有完成，不能兑存钱。');
            return true;
        }

        if (!is_numeric($amount)) {
            $ob->ssend('指令格式：withdraw <数量>');
            return true;
        }

        $value = $me->query('balance');
        if ($value < $amount) {
            $ob->ssend('你没这么多存款 ！！');
            return true;
        }

        if ($this->query('richness') < $amount) {
            $ob->ssend($this->query('name') . '的现钱已经不够了．．．');
            return true;
        }
        global $CHINESE_D;
        $this->add('richness', -$amount);
        $value -= $amount;
        $me->set('balance', $value);
        $this->pay_player($me, $amount);
        if ($amount < 100)
		    $ob->ssend('你取出了' . $CHINESE_D->chinese_number($amount) . '文钱。');
        else
			$ob->ssend('你取出了' . $CHINESE_D->chinese_number($amount / 100) . '两' . ($amount % 100 ? '又' . $CHINESE_D->chinese_number($amount % 100) . '文钱。':'。'));
        return true;
    }

    private function pay_player($me, $amount)
    {
        global $OBJECT;
        if ($amount < 1) 
            $amount = 1;
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

    public function do_convert($ob, $amount = null, $fromtype = null, $to = 'to', $totype = null)
    {
        $me = $ob->body;
        if ($me->is_busy()) {
            $ob->ssend('你的动作还没有完成，不能兑存钱。');
            return true;
        }

        $typearray = array('tenthousand-cash', 'thousand-cash', 'gold', 'silver', 'coin');
        if (!is_numeric($amount) || !in_array($fromtype, $typearray) || !in_array($totype, $typearray)) {
            $ob->ssend('指令格式：convert <数量> <货币种类> to <货币种类>');
            return true;
        }
           
        $money = $me->is_carry($fromtype);
        if (null == $money) {
            $ob->ssend('你身上没有这种货币。');
            return true;
        }

        if ($amount < 1) {
            $ob->ssend('兑换货币一次至少要兑换一个。');
            return true;
        }

        if ($money->query('type') != 'money') {
            $ob->ssend('只可以兑换货币。');
            return true;
        }

        if ($money->query_amount() < $amount) {
            $ob->ssend('你身上没有那麽多' . $money->query('name') . '。');
            return true;
        }
        global $OBJECT, $CHINESE_D;
        $totype = str_replace('-', '', $totype);
        $to_money = $OBJECT->create_objects('/obj/money/' . $totype);

        $basevalue1 = $money->query('base_value');
        $basevalue2 = $to_money->query('base_value');
        if ($basevalue1 < $basevalue2) 
            $amount -= $amount % ($basevalue2 / $basevalue1);
        if ($amount == 0) {
            $ob->ssend('这些' . $money->query('name') . '的价值太低了，换不起。');
            return true;
        }

        $money->add_amount(-$amount);
		$to_money->set_amount($amount * $basevalue1 / $basevalue2);
		$to_money->move($me);

        msg::message('vision', '$N从身上取出' . $CHINESE_D->chinese_number($amount) . $money->query('base_unit') . $money->query('name') . '换成' . $CHINESE_D->chinese_number($amount * $basevalue1 / $basevalue2) . $to_money->query('base_unit') . $to_money->query('name') . '。', $me);
        $me->start_busy(1);
        return true;
    }
}
 