<?php
/**
*   fight
*
*/
namespace cmds\std;

use \std\msg;

class fight
{
    function __construct()
    {

    }

    public function do_cmd($ob, $target = null)
    {
        $me = $ob->body;
        $env = $me->place;
        if ($env == null) {
            $ob->ssend('异常空间无法战斗。');
            return false;
        }

        if ($env->query('no_fight') != null) {
            $ob->ssend('这里禁止战斗。');
            return false;
        }

        if ($target == null || $target == '') {
            $ob->ssend('你想攻击谁？');
            return false;
        }

        if ($me->query('id') == $target) {
            $ob->ssend('你不能攻击自己。');
            return false;
        }

        if (!$me->is_environment($target)) {
            $ob->ssend('找不到' .$target . '。');
            return false;
        }
        
        $target = $me->is_environment($target);

        if (!$target->is_character() || $target->is_corpse()) {
            $ob->ssend('看清楚一点，那并不是活物。');
            return false;
        }

        global $RANK_D;
        if ($target->is_player()) {
            if ($target->query_temp('pending/fight') != $me) {
                msg::message('vision', '$N对著$n说道：' . $RANK_D->query_self($me) . $me->query('name') . '领教' . $RANK_D->query_respect($target) . '的高招！', $me, $target);
                $me->set_temp("pending/fight", $target);
                $target->get_conn()->ssend('如果你愿意和对方进行比试，请你也对' . $me->query('name') . '(' . $me->query('id') . ')下一次 fight 指令。');
                $ob->ssend('由於对方是由玩家控制的人物，你必须等对方同意才能进行比试。');
            }
            else {
                msg::message('vision', '$N对著$n说道：' . $RANK_D->query_self($me) . $me->query('name') . '领教' . $RANK_D->query_respect($target) . '的高招！', $me, $target);
                $me->fight_ob($target);
                $target->fight_ob($me);
            }
        }
        else {
            if ($target->query('can_speak')) {
                msg::message('vision', '$N对著$n说道：' . $RANK_D->query_self($me) . $me->query('name') . '领教' . $RANK_D->query_respect($target) . '的高招！', $me, $target);
                
                if (!$target->is_character()|| !$target->accept_fight($me) ) {
                    $ob->ssend('看起来' . $target->query('name') . '并不想跟你较量。');
                }
                else {
                    if (!$me->have_heart) 
                        $me->have_heart = true;
                    if (!$target->have_heart)
                        $target->have_heart = true;
                    $me->fight_ob($target);
                    $target->fight_ob($me);
                }
            }
            else {
                 msg::message('vision', '$N大喝一声，开始对$n发动攻击！', $me, $target);
                 if (!$me->have_heart) 
                     $me->set_heart_beat(1);
                 if (!$target->have_heart)
                     $target->set_heart_beat(1);
                 $me->fight_ob($target);
                 $target->fight_ob($me);
            }
        }
    }

    public function help() 
    {
        $ret = "指令格式 : fight <人物> 这个指令让你向一个人物「讨教」或者是「切磋武艺」，这种形式的战斗纯粹是点到为止，因此只会消耗体力，不会真的受伤，但是并不是所有的  NPC 都喜欢打架，因此有许多状况你的比武要求会被拒绝。其他相关指令: kill";
        return $ret;
    }
}
