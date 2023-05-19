<?php
/**
*  money
*
*/
namespace obj\money;

use std\obj;

class money extends obj
{
    function __construct()
    {
        parent::__construct();
        $this->name = '钱';
        $this->id = 'money';
        $this->long = '这是钱。';
        $this->unit = '元';
        $this->type = 'money';
    }

    public function move($object, $ob = null)
    {
        if (parent::move($object, $ob)) {
            $env = $this->get_env();
            $objs = $env->all_inventory();
            foreach ($objs as $k => $v) {
                if (($v != $this) && ($v->id == $this->id) && ($v->name == $this->name) && ($v->query('type') == 'money')) {
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
