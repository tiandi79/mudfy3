<?php
/**
*  当铺老板定义
*
*/

namespace std;

class pawnowner extends char
{      
    function __construct() 
    {
        parent::__construct();
    }

    public function do_list($ob, $arg = null)
    {
        if (!$goods_list = $this->query("vendor_goods")) {
            $ob->ssend('这儿的东西全卖光了。');
            return true;
        }
        
	    if (count($goods_list) < 1) {
            $ob->ssend('这儿的东西全卖光了。');
            return true;
        }

        $ob->ssend('你可以购买下列这些东西：');
        global $OBJECT;
        foreach ($goods_list as $k => $v) {
            if ($goods = $OBJECT->create_objects($k)) {
                $ob->ssend($goods->query('name') . '(' . $goods->query('id') . ')' . ' - ' . $this->price_string($goods->query('value')));
                $goods->destruct();
            }
        }
        return true;
    }

    private function value_string($value)
    {
        global $CHINESE_D;
        if ($value < 1) 
            $value = 1;
	    elseif ($value < 100)
		    return $CHINESE_D->chinese_number($value) . "文钱";
	    else
		    return $CHINESE_D->chinese_number($value / 100) . "两" . ($value % 100 ? "又" . $CHINESE_D->chinese_number($value % 100) . "文钱": "");
    }   

    private function price_string($value)
    {
        if ($value % 10000 == 0)
		    return ($value / 10000) . "两黄金";
	    if ($value % 100 == 0)
		    return ($value / 100) . "两银子";
	    return $value . "文钱";
    }

    public function buy_object($me, $what)
    {
        if (!$goodslist = $this->query("vendor_goods"))
            return 0;

        global $OBJECT;
        foreach ($goodslist as $k => $v) {
            if ($goods = $OBJECT->create_objects($k)) {
                if ($goods->query('id') == $what) {
                    $price = $goods->query('value');
                    $goods->destruct();
                    return $price;
                }
                else
                    $goods->destruct();
            }
        }
        return 0;
    }

    public function compelete_trade($me, $item)
    {
        $last = '';
        if (!$goodslist = $this->query("vendor_goods"))
            return false;

        global $OBJECT;
        foreach ($goodslist as $k => $v) {
            if ($goods = $OBJECT->create_objects($k)) {
                if ($goods->query('id') == $item) {
                    $v--;
                    $goodslist[$k] = $v;
                    if ($v <= 0) {
                        unset($goodslist[$k]);
                        $last = '最后';                        
                    }
                    
                    $this->set('vendor_goods', $goodslist);
                    if ($goods->move($me)) {
                        $me->get_conn()->ssend('你向' . $this->query('name') . '买下' . $last . '一' . $goods->query('unit') . $goods->query('name') . '。');
                        return true;
                    }
                }
                $goods->destruct();
            }
        }
    }

    public function do_value($ob, $arg)
    {
        $me = $ob->body;
        $obj = $me->is_carry($arg);

        if ($arg == null) {
            $ob->ssend('你要拿什麽物品给当铺估价？');
            return true;
        }

        if ($obj->query('type') == 'money') {
            $ob->ssend('这是「钱」，你没见过吗？');
            return true;
        }

        $value = $obj->query('value');
        if (!$value || $value < 5) {
            $ob->ssend($obj->query('name') . '并不值几文钱。');
        } else {
            $ob->ssend($obj->query('name') . '价值' . $this->value_string($value) . '。<br>如果你要典当(pawn)，可以拿到'. $this->value_string($value * 25 / 100) . '，如果卖断(sell)，可以拿到' . $this->value_string($value * 80 / 100) . '。');
        }
        return true;
    }

    public function do_sell($ob, $arg)
    {
        $me = $ob->body;
        $obj = $me->is_carry($arg);

        if ($arg == null || !$obj) {
            $ob->ssend('你要卖断什麽物品？');
            return true;
        }

        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成，不能卖物品。');
            return true;
        }

        if ($obj->query('type') == 'money') {
            $ob->ssend('你要卖「钱」？');
            return true;
        }

        $value = $obj->query('value');
        if (!$value || $value < 5) {
            $ob->ssend($obj->query('name') . '并不值几文钱。');
            return true;
        }

        if ($obj->query('no_sell') != null) {
            $ob->ssend('这样东西不能卖。');
            return true;
        }

        if ($this->query('richness') < $value * 80 /100) {
            $ob->ssend($this->query('name') . '的现钱已经不够了．．.');
            return true;
        }

        $this->add('richness', - intval($value * 80 / 100));
        msg::message('vision', '$N把身上的' . $obj->query("name") . '卖掉了' . $this->value_string(intval($value * 80 / 100)) . '。', $me);
        $base = $obj->get_basename(1);
        $goods = $this->query('vendor_goods');
        $update = false;
        $tmp_array = array();
        if ($goods != null) {
            foreach ($goods as $k => $v) {
                if ($k == $base) {
                    $tmp_array[$k] = $v + 1;
                    $update = true;
                } else 
                    $tmp_array[$k] = $v;
            }
        }
        if (!$update) {
            $tmp_array[$base] = 1;
        }

        $this->set('vendor_goods', $tmp_array); 
        $this->pay_player($me, intval($value * 80 / 100));
        
        $obj->move($me->get_env());
        $obj->destruct();
        $me->start_busy(1);
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

    public function do_pawn($ob, $arg)
    {
        $me = $ob->body;
        $pawns = $me->query('pawns');
        $max_pawn = $me->query('max_pawn');
        if ($max_pawn == null)
            $max_pawn = 10;
        if ($arg == null) {
            if ($pawns == null || count($pawns) < 1) {
                $ob->ssend('没有任何典当的物品。');
            } else {
                $ob->ssend('你目前典当的物品有：');
                $ob->ssend(' 编号  物品  赎银 ');
                foreach ($pawns as $k => $v) {
                    $ob->ssend($k . ' ' . $v['name']. ' ' . $this->value_string(intval($v['value'] * 3 / 4)));
                }
            }
        } else {
            $obj = $me->is_carry($arg);
            if (!$obj)
                $ob->ssend('你要典当什么东西？');
            else {
                $value = $obj->query('value');
                if ($obj->query('type') == 'money')
                    $ob->ssend('你要当「钱」？');
                elseif ($obj->query('no_pawn') != null)
                    $ob->ssend('这样东西当铺不收。');
                elseif ($value < 5)
                    $ob->ssend('这样东西并不值很多钱。');
                elseif (count($pawns) >= $max_pawn)
                    $ob->ssend('你已典当太多物品了。');
                elseif ($me->is_busy())
                    $ob->ssend('你上一个动作还没有完成，不能典当物品。');
                elseif ($this->query('richness') < $value * 25 /100) 
                    $ob->ssend($this->query('name') . '的现钱已经不够了．．.');
                else {
                    $this->add('richness', - intval($value * 25 / 100));
                    msg::message('vision', '$N把身上的' . $obj->query("name") . '拿出来典当了' . $this->value_string(intval($value * 25 / 100)) . '。', $me);
                    $objinfo = array('name' => $obj->name, 'basename' => $obj->get_basename(1), 'value' => $obj->query('value'));
                    $pawns[] = $objinfo;
                    $me->set('pawns', $pawns);
                    $this->pay_player($me, intval($value * 25 / 100));
        
                    $obj->move($me->get_env());
                    $obj->destruct();
                    $me->start_busy(1);
                }
            }
        }
        return true;
    }

    public function do_redeem($ob, $arg = null)
    {
        $me = $ob->body;
        $pawns = $me->query('pawns');
        if ($arg == null)
            $ob->ssend('指令格式：redeem <物品编号>');
        elseif (!is_numeric($arg))
            $ob->ssend('物品编号必须为数字。');
        elseif (!isset($pawns[$arg]))
            $ob->ssend('有这个物品编号吗？');
        elseif ($me->is_busy())
            $ob->ssend('你上一个动作还没有完成，不能赎回物品。');
        else {
            $objinfo = $pawns[$arg];
            $amount = intval($objinfo['value'] * 3 / 4);
            if ($afford = $this->affordable($me, $amount)) {
                $this->pay_him($me, $afford - $amount);
                global $OBJECT;
                $obj = $OBJECT->create_objects($objinfo['basename']);
                $obj->move($me);
                unset($pawns[$arg]);
                $me->set('pawns', $pawns);
                $this->add("richness", $amount);
		        $me->save();
                msg::message('vision', '$N赎回了$n。', $me, $obj);
            } else
                $ob->ssend('你的钱不够。');
	        $me->start_busy(1);
        }
        return true;
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

        if ($amount < 1)
            $amount = 1;
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
