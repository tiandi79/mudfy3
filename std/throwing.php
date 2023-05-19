<?php
/**
*   投掷类
*
*/
namespace std;

class throwing extends weapon
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'throwing');
        $this->set('material', 'steel');
        $this->set('weapon_prop', 0);
        $this->set_weight(1);
        $this->set('skill_type', 'throwing');
        $this->set('type', 'throwing');
        $this->set('verbs', array("throw"));
        $this->set('actions', $this->query_action());
    }

    public function move($object, $ob = null)
    {
        if (parent::move($object, $ob)) {
            $env = $this->get_env();
            $objs = $env->all_inventory();
            foreach ($objs as $k => $v) {
                if (($v != $this) && ($v->id == $this->id) && ($v->name == $this->name) && ($v->query('base_unit') != null) && ($this->query_temp('no_combine') == null)) {
                    $this->set_amount($this->query_amount() + $v->query_amount());
                    $v->destruct();
                }
            }
            return true;
        }
        return false;
    }
}
