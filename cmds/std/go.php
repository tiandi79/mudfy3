<?php
/**
*  行走
*
*/
namespace cmds\std;

use std\msg;

class go
{
    public $dirs;
    function __construct()
    {
        $this->init();
    }

    private function init()
    {
        $this->dirs = array("north"=>"北","south"=>"南","east"=>"东","west"=>"西",
            "northup"=>"北边","southup"=>"南边","eastup"=>"东边","westup"=>"西边",
            "northdown"=>"北边","southdown"=>"南边","eastdown"=>"东边","westdown"=>"西边",
            "northeast"=>"东北","northwest"=>"西北","southeast"=>"东南","southwest"=>"西南",
            "up"=>"上","down"=>"下","out"=>"外");
    }

    public function do_cmd($ob, $dir = null)
    {
        if (!isset($dir)) {
            $ob->ssend('你要往哪个方向走？');
            return false;
        }
        
        $user = $ob->body;
        if ($user->over_encumbranced()) {
            $ob->ssend('你的负荷过重，动弹不得。');
            return false;
        }

        if ($user->is_busy()) {
            $ob->ssend('你现在忙得很，不能移动。');
            return false;
        }

        if (!isset($user->place)) {
            $ob->ssend('你现在哪里也去不了。');
            return false;
        }
        $place = $user->place;
        global $OBJECT;
        $room = $OBJECT->get_room($place->id);

        if (null !== ($room->query('exits'))) {
            $exits = $room->query('exits');
            if (!isset($exits[$dir])) {
                $ob->ssend('这个方向没有出路。');
                return false;   
            }
            elseif (isset($room->door[$dir]) && ($room->door[$dir]['status'] == 1)) {
                $ob->ssend('这个方向的门是关着的。');
                return false;   
            }
            elseif (null !== ($room->query('blocker'))) {
                $ob->ssend('这个方向的路被人挡住了。');
                return false;   
            }
            elseif (method_exists($room, 'valid_leave') && !$room->valid_leave($user, $dir)) {
                $ob->ssend('你目前无法朝这个方向离开。');
                return false;
            }
            
            $newplace = $exits[$dir];
            $file = ROOT_DIR . D_DIR . $newplace .'.php';

            /* linux路径兼容 */
            if (DIRECTORY_SEPARATOR !== '\\')
                $file = str_replace('\\', '/', $file);

            if (!file_exists($file)) {
                $ob->ssend('这个方向暂未开放，无法移动到这个地方。');
                return false;   
            }
                
            $newroom = $OBJECT->get_room($newplace);

            if (null == $newroom) {
                $ob->ssend(SYS_ERR);
                return false;   
            }

            if ($user->is_fighting())
            {
                if (!$this->check_flee($user, $dir)) {
                    $ob->ssend('你被挡了回来。');
                    return false;
                }
                $this->drop_things($user);
                $leave_msg = "往" . $this->dirs[$dir] . "落荒而逃了。";
                $arrive_msg = "跌跌撞撞地跑了过来，模样有些狼狈。";
            }
            else {
                if (null !== $user->query('leave_msg'))
                    $leave_msg = "往" . $this->dirs[$dir] . $user->query('leave_msg') ." 。";
                else
                    $leave_msg = "往" . $this->dirs[$dir] . "离开。";

                if (null !== $user->query('arrive_msg'))
                    $arrive_msg = $user->query('arrive_msg') ." 。";
                else
                    $arrive_msg = "走了过来。";
            }

            if (!$user->is_player() && null !== $newroom->query('NONPC')) {
                $ob->ssend("你不可去那里。");
                return false;
            }

            if (!$newroom->valid_enter($user)) {
                $ob->ssend("你不可去那里。");
                return false;
            }

            $objs = $place->all_inventory();
            foreach ($objs as $v) {
                if ($v->is_player() && $v->query('id') != $user->query('id') && $v->query_temp('block_msg/all') == null && (!$user->is_ghost() || ($user->is_ghost && $v->wizardp()) || ($user->is_ghost && $v->query_temp('apply/astral_vision'))))
                    $v->get_conn()->ssend($user->query('name') . $leave_msg);
            }

            $oldobjs = $objs;
            
            if ($user->move($newroom)) {
                $user->remove_all_enemy();
            
                $env = $user->place;
                if (method_exists($env, 'init_coming')) {
                    $env->init_coming($user);
                }

                if (!$user->is_ghost()) {
                    $objs = $user->place->all_inventory();
                    foreach ($objs as $v) {
                        /* 处理npc处于同一场景时动作 */
                        if (method_exists($v, 'init_coming') && !isset($v->timerid)) {
                            $v->init_coming($user);
                        }
                        if ($v->is_player() && $v->query('id') != $user->query('id') && $v->query_temp('block_msg/all') == null)
                            $v->get_conn()->ssend($user->query('name') . $arrive_msg);
                    }
                } else {
                    $objs = $user->place->all_inventory();
                      
                    foreach ($objs as $v) {
                        /* 处理npc处于同一场景时动作 */
                        if (method_exists($v, 'init_coming') && !isset($v->timerid) && $v->query_temp('apply/astral_vision') != null) {
                            $v->init_coming($user);
                        }
                        if ((($v->is_player() && $v->query_temp('block_msg/all') == null && $v->query_temp('apply/astral_vision') != null) || $v->wizardp()) && $v->query('id') != $user->query('id'))
                            $v->get_conn()->ssend($user->query('name') . $arrive_msg);
                    }
                }

                foreach ($oldobjs as $v) {
                    if ($v != $user && $v->is_character())
                        $v->follow_me($user, $dir);
                }
            }
        }
        else {
            $ob->ssend('这个方向没有出路。');
            return false;   
        }
    }

    public function check_flee($me, $arg)
    {
        $myexp = $me->query('combat_exp');
        /* 新手大概率逃跑 */
        if ($me->is_player() && rand(0, $myexp) < 300)
            return true;

        $enemy = $me->query_enemy();
        if ($enemy != null) {
            foreach ($enemy as $k => $v) {
                if ($v->living() && $v->query('is_unconcious') == null) {
                    global $COMBAT_D;
                    $fp = $COMBAT_D->skill_power($me, "move", 3);
                    if ($fp < 1)
                        $fp = 1;
                    $bp = $COMBAT_D->skill_power($v, "move", 3);
                    if ($bp < 1)
                        $bp = 1;
                    if (rand(0, ($fp * 2 + $bp) > $fp * 2)) {
                        msg::message('vision', 'YEL$N向' . $this->dirs[$arg] . '逃去！NOR', $me);
                        msg::message('vision', 'RED$N身影一闪，挡在了$n的面前！NOR', $v, $me);
                        return false;
                    }
                }
            }
        }
    }

    private function drop_things($me)
    {
        $objs = $me->all_inventory();
        foreach ($objs as $k => $v) {
            if ($v->query('no_drop') != null || $v->query('owner') != null || $v->query('equipped'))
                continue;
            $max = $me->query_max_encumbrance();
            $env = $me->get_env();
            if (rand(0, $max) < $v->query_weight()) {
                msg::message('vision', '在慌乱中...', $me);
                $me->do_cmd($me->get_conn(), 'drop ' . $v->id);
            }
        }
    }
}
