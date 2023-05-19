<?php
/**
*  显示用户当前状态
* 
*/

namespace cmds\usr;

class hp
{
    function __construct() 
    {
    }

    public function do_cmd($ob, $who = null)
    {
        $me = $ob->body;
        if (isset($who) && $ob->body->wizardp()) {
            if ($me->is_environment($who)) {
                $who = $me->is_environment($who);
                $ob->ssend('显示' . $who->name .'的状态');
                $ob->ssend('精力 '. $who->gin . '/' . $who->eff_gin . '(' . intval($who->eff_gin * 100 / $who->max_gin) . '%) 食物 '. $who->food * 100 / $who->max_food_capacity() . '%');
                $ob->ssend('气血 '. $who->kee . '/' . $who->eff_kee . '(' . intval($who->eff_kee * 100 / $who->max_kee) . '%) 饮水 '. $who->water * 100 / $who->max_water_capacity() . '%');
                $ob->ssend('心神 '. $who->sen . '/' . $who->eff_sen . '(' . intval($who->eff_sen * 100 / $who->max_sen) . '%) 评价 '. $who->score);
                $ob->ssend('灵力 '. $who->atman . '/' . $who->max_atman . '(' . $who->atman_factor . ') 杀气 '. $who->bellicosity);
                $ob->ssend('内力 '. $who->force . '/' . $who->max_force . '(' . $who->force_factor . ') 潜能 '. $who->potential);
                $ob->ssend('法力 '. $who->mana . '/' . $who->max_mana . '(' . $who->mana_factor . ') 经验 '. $who->combat_exp);
            }
            else {
                $ob->ssend('当前场景没有' . $who .'这个人。');
            }
        }
        else {
            $ob->ssend('显示自己的状态');
            $ob->ssend('精力 '. $me->gin . '/' . $me->eff_gin . '(' . intval($me->eff_gin * 100 / $me->max_gin) . '%) 食物 '. $me->food * 100 / $me->max_food_capacity() . '%');
            $ob->ssend('气血 '. $me->kee . '/' . $me->eff_kee . '(' . intval($me->eff_kee * 100 / $me->max_kee) . '%) 饮水 '. $me->water * 100 / $me->max_water_capacity() . '%');
            $ob->ssend('心神 '. $me->sen . '/' . $me->eff_sen . '(' . intval($me->eff_sen * 100 / $me->max_sen) . '%) 评价 '. $me->score);
            $ob->ssend('灵力 '. $me->atman . '/' . $me->max_atman . '(' . $me->atman_factor . ') 杀气 '. $me->bellicosity);
            $ob->ssend('内力 '. $me->force . '/' . $me->max_force . '(' . $me->force_factor . ') 潜能 '. $me->potential);
            $ob->ssend('法力 '. $me->mana . '/' . $me->max_mana . '(' . $me->mana_factor . ') 经验 '. $me->combat_exp);
        }
    }

    public function help() 
    {
        $ret = "指令格式 : hp<br>这个指令显示你当前状态.";
        return $ret;
    }
}
