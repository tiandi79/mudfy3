<?php
/**
*  tenthousandcash
*
*/
namespace obj\money;

class tenthousandcash extends money
{
    function __construct()
    {
        parent::__construct();
        $this->name = '一万两银票';
        $this->id = 'tenthousand-cash';
        $this->long = '一张面额值一万两银子的银票。';
        $this->unit = '叠';
        $this->set("base_value", 1000000);
		$this->set("base_unit", "张");
		$this->set("base_weight", 3);
        $this->set_amount(1);
        global $CHINESE_D;
        $this->set('short', $CHINESE_D->chinese_number($this->query_amount()) . $this->query('base_unit') . $this->query('name') . '(' . $this->query('id') . ')'); 
    }
}
