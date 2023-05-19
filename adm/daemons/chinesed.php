<?php
/**
*  中文化
*
*/
namespace adm\daemons;

class chinesed
{
    public $c_digit = array("零","十","百","千","万","亿","兆");
    public $c_num = array("零","一","二","三","四","五","六","七","八","九","十");
    public $sym_tien = array("甲","乙","丙","丁","戊","己","庚","辛","壬","癸");
    public $sym_dee = array("子","丑","寅","卯","辰","巳","午","未","申","酉","戌","亥");

    function __construct() 
    {
        $this->channel_id = "连线精灵";
    }

    public function chinese_number($i) 
    {
	    if($i < 0) 
            return "负" . $this->chinese_number(-$i);
	    if($i < 11)
            return $this->c_num[$i];
	    if($i < 20) 
            return $this->c_num[10] . $this->c_num[$i-10];
	    if($i < 100) {
		    if( $i % 10 ) 
                return $this->c_num[intval($i/10)] . $this->c_digit[1] . $this->c_num[$i % 10];
		    else
                return $this->c_num[intval($i/10)] . $this->c_digit[1];
        }
	    if($i < 1000) {
            if($i % 100 == 0)
                return $this->c_num[intval($i/100)] . $this->c_digit[2];
            elseif($i % 100 < 10)
                return $this->c_num[intval($i/100)] . $this->c_digit[2] . $this->c_num[0] . $this->chinese_number($i % 100);
            elseif($i % 100 < 20)
                return $this->c_num[intval($i/100)] . $this->c_digit[2] . $this->c_num[1] . $this->chinese_number($i % 100);
            else 
                return $this->c_num[$i /100] . $this->c_digit[2] . $this->chinese_number($i % 100);
        }
        if($i < 10000) {
            if($i % 1000 == 0)
                return $this->c_num[intval($i/1000)] . $this->c_digit[3];
            elseif($i % 1000 < 100)
                return $this->c_num[intval($i/1000)] . $this->c_digit[3] . $this->c_digit[0] . $this->chinese_number($i % 1000);
            else
                return $this->c_num[intval($i/1000)] . $this->c_digit[3] . $this->chinese_number($i % 1000);
        }
        if( $i < 100000000) {
            if($i % 10000 == 0)
                return $this->chinese_number(intval($i/10000)) . $this->c_digit[4];
            elseif($i % 10000 < 1000)
                return $this->chinese_number(intval($i/10000)) . $this->c_digit[4] . $this->c_digit[0] . $this->chinese_number($i % 10000);
            else
                return $this->chinese_number(intval($i/10000)) . $this->c_digit[4] . $this->chinese_number($i % 10000);
        }
        if($i < 1000000000000) {
            if($i % 100000000 == 0)
                return $this->chinese_number(intval($i/100000000)) . $this->c_digit[5];
            else if($i % 100000000 < 10000000)
                return $this->chinese_number(intval($i/100000000)) . $this->c_digit[5] . $this->c_digit[0] . $this->chinese_number($i % 100000000);
            else
                return $this->chinese_number(intval($i/100000000)) . $this->c_digit[5] . $this->chinese_number($i % 100000000);
        }
            if($i % 1000000000000 == 0)
                return $this->chinese_number(intval($i/1000000000000)) . $this->c_digit[6];
            else if($i % 1000000000000 < 100000000000)
                return $this->chinese_number(intval($i/1000000000000)) . $this->c_digit[6] . $this->c_digit[0] . $this->chinese_number($i % 1000000000000);
            else
                return $this->chinese_number(intval($i/1000000000000)) . $this->c_digit[6] . $this->chinese_number($i % 1000000000000);
    }

    public function chinese_date($date)
    {
        $local = localtime($date, true);
        return $this->sym_tien[$local['tm_year'] % 10] . $this->sym_dee[$local['tm_year'] % 12] . '年' . $this->chinese_number($local['tm_mon'] + 1) . '月' . $this->chinese_number($local['tm_mday']) . '日' . $this->sym_dee[(($local['tm_hour'] + 1) % 24) / 2] . '时' . $this->chinese_number(($local['tm_min'] + 1) % 2 * 2 + $local['tm_min'] / 30 + 1) . '刻';
    }
}
