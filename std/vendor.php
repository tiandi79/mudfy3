<?php
/**
*  供应商定义
*
*/

namespace std;

class vendor extends char
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
}
