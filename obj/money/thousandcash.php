<?php
/**
*  thousandcash
*
*/
namespace obj\money;

class thousandcash extends money
{
    function __construct()
    {
        parent::__construct();
        $this->name = '一千两银票';
        $this->id = 'thousand-cash';
        $this->long = '一张面额值一千两银子的银票。';
        $this->unit = '叠';
        $this->set("base_value", 100000);
		$this->set("base_unit", "张");
		$this->set("base_weight", 3);
        $this->set_amount(1);
        global $CHINESE_D;
        $this->set('short', $CHINESE_D->chinese_number($this->query_amount()) . $this->query('base_unit') . $this->query('name') . '(' . $this->query('id') . ')'); 
    }
}
