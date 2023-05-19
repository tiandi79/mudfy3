<?php
/**
*  silver
*
*/
namespace obj\money;

class silver extends money
{
    function __construct()
    {
        parent::__construct();
        $this->name = '银子';
        $this->id = 'silver';
        $this->long = '白花花的银子，人见人爱的银子。';
        $this->unit = '些';
        $this->set("base_value", 100);
		$this->set("base_unit", "两");
		$this->set("base_weight", 37);
        $this->set_amount(1);
        global $CHINESE_D;
        $this->set('short', $CHINESE_D->chinese_number($this->query_amount()) . $this->query('base_unit') . $this->query('name') . '(' . $this->query('id') . ')'); 
    }
}
