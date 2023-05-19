<?php
/**
*  恢复
*
*/

namespace cmds\wiz;

class full
{
    function __construct() 
    {

    }

    public function do_cmd($ob, $arg = null) 
    {
        $me = $ob->body;
        if (!$ob->body->wizardp()) {
            $ob->ssend("什么？");
            return;
        }
        if (!isset($arg)) 
            $target = $me;
        elseif ($arg != null) {
            $target = $me->is_environment($arg);       
        }

        if ($target && $target->is_character()) {            
            $target->set('eff_gin', $target->query('max_gin')); 
            $target->set('eff_kee', $target->query('max_kee')); 
            $target->set('eff_sen', $target->query('max_sen')); 
            $target->set('gin', $target->query('max_gin')); 
            $target->set('kee', $target->query('max_kee')); 
            $target->set('sen', $target->query('max_sen')); 
            $target->set('force', $target->query('max_force')); 
            $target->set('mana', $target->query('max_mana')); 
            $target->set('atman', $target->query('max_atman')); 
            $target->set('food', $target->max_food_capacity());
            $target->set('water', $target->max_water_capacity());
            $ob->ssend('恢复成功。');
        }
    }

    public function help() 
    {
        $ret = "指令格式 : full<br>利用此指令可完全恢复生物的状态.";
        return $ret;
    }
}
