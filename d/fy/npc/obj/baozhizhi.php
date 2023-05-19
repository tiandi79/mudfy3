<?php
/**
*   油油的纸
*
*/
namespace d\fy\npc\obj;

use std\obj;
use std\msg;

class baozhizhi extends obj
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'youzhi');
        $this->set('name', '油油的纸');
        $this->set('value', 1);
        $this->set('unit', '张');
        $this->set('long', '这是张油斑点点的破纸片儿。但好象有点名堂。');
        $this->set_weight(5);
    }

    public function do_print($ob, $arg)
    {
        $me = $ob->body;
        if ($this->get_env() != $me) 
            return false;

        if ($arg == null) {
            $ob->ssend('指令格式：print <角色ID>');
            return true;
        }

        global $OBJECT;
        foreach ($OBJECT->_objs as $v) {
            if ($arg == $v->id && ($v->type == 'char' || $v->type == 'user')) {
                msg::message('vision', '$N把' . $v->name . '写在$n上。', $me, $this);
                $this->set('targetname', $v->name);
                $this->set('targetid', $v->id);
                $this->set('targetgender', $v->gender);
                $this->set('long', '这是一张' . $this->query('name') . '，上面写着"' . $v->name . '"几个小字。');
                return true;
            }
        }
        msg::message('vision', '$N把' . $arg . '写在$n上。', $me, $this);
        $this->set('long', '这是一张' . $this->query('name') . '，上面写着"' . $arg . '"几个小字。');
        return true;
    }
}
