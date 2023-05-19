<?php
/**
*   桃符纸
*
*/
namespace obj\obj;

use std\obj;

class paperseal extends obj
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'paper');
        $this->set('name', '桃符纸');
        $this->set('base_value', 1000);
        $this->set('unit', '叠');
        $this->set('long', '这是道士们用来画符的符纸，具有封存法力的功用。');
        $this->set("base_unit", '张');
		$this->set("base_weight", 5);
        $this->set_weight(80);
        $this->set_amount(1);
    }

    public function move($object, $ob = null)
    {
        if (parent::move($object, $ob)) {
            $env = $this->get_env();
            $objs = $env->all_inventory();
            foreach ($objs as $k => $v) {
                if (($v != $this) && ($v->id == $this->id) && ($v->name == $this->name) && ($v->query('name') == '桃符纸')) {
                    if ($this->query_temp('no_combine') == null) {
                        $this->set_amount($this->query_amount() + $v->query_amount());
                        $v->destruct();
                    }
                }
            }
        }
        return true;
    }
}
