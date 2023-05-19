<?php
/**
*  显示用户携带的物品
* 
*/

namespace cmds\usr;

class inventory
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
                if ($who->is_character())
                    $prep = '身上';
                else
                    $prep = '上';
                $objs = $who->all_inventory();
                if (count($objs) == 0) {
                    $ob->ssend($who->name . $prep. '没有任何东西。');
                }
                else {
                    $ob->ssend($who->name . $prep . '带著：(负重 ' . intval($who->query_encumbrance() * 100 / $who->query_max_encumbrance()) . '%)');
                    $weapon = $who->query_temp('weapon');
                    $armor = $who->query_temp('armor');
                    foreach ($objs as $v) {
                        if ($v->query('short') == null) {
                            if (null != $v->query('equipped'))
                                $ob->ssend("  √" . $v->query('name') . '(' . $v->query('id') . ')');
                            else
                                $ob->ssend($v->query('name') . '(' . $v->query('id') . ')');
                        } else {
                            if (null != $v->query('equipped'))
                                $ob->ssend("  √" . $v->query('short'));
                            else
                                $ob->ssend($v->query('short'));
                        }
                    }
                }            
            }
        }
        else {
            $objs = $me->all_inventory();
            if (count($objs) == 0) {
                $ob->ssend('你身上没有任何东西。(负重 ' . intval($me->query_encumbrance() * 100 / $me->query_max_encumbrance()) . '%)');
            }
            else {
                $ob->ssend('你身上身上身上带著：(负重 ' . intval($me->query_encumbrance() * 100 / $me->query_max_encumbrance()) . '%)');
                foreach ($objs as $v) {
                    if ($v->query('short') == null) {
                        if (null != $v->query('equipped'))
                            $ob->ssend("  √" . $v->query('name') . '(' . $v->query('id') . ')');
                        else
                            $ob->ssend($v->query('name') . '(' . $v->query('id') . ')');
                    } else {
                        if (null != $v->query('equipped'))
                            $ob->ssend("  √" . $v->query('short'));
                        else
                            $ob->ssend($v->query('short'));
                    }
                }
            }            
        }
    }

    public function help() 
    {
        $ret = "指令格式: inventory<br>这个指令显示你身上的物品。注 : 此指令可以i代替。";
        return $ret;
    }
}
