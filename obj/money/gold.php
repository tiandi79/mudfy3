<?php
/**
*  gold
*
*/
namespace obj\money;

class gold extends money
{
    function __construct()
    {
        parent::__construct();
        $this->name = '黄金';
        $this->id = 'gold';
        $this->long = '黄澄澄的金子，人见人爱的金子，啊～～金子！';
        $this->unit = '些';
        $this->set("base_value", 10000);
		$this->set("base_unit", "两");
		$this->set("base_weight", 37);
        $this->set_amount(1);
        global $CHINESE_D;
        $this->set('short', $CHINESE_D->chinese_number($this->query_amount()) . $this->query('base_unit') . $this->query('name') . '(' . $this->query('id') . ')'); 
    }
}
