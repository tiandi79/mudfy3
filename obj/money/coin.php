<?php
/**
*  coin
*
*/
namespace obj\money;

class coin extends money
{
    function __construct()
    {
        parent::__construct();
        $this->name = '钱';
        $this->id = 'coin';
        $this->long = '这是流通中单位最小的货币，约要一百文钱才值得一两银子。';
        $this->unit = '些';
        $this->set("base_value", 1);
		$this->set("base_unit", "文");
		$this->set("base_weight", 1);
        $this->set_amount(1);
        global $CHINESE_D;
        $this->set('short', $CHINESE_D->chinese_number($this->query_amount()) . $this->query('base_unit') . $this->query('name') . '(' . $this->query('id') . ')'); 
    }
}
