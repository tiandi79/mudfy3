<?php
/**
*   kill
*
*/
namespace cmds\std;

use \std\msg;

class kill
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
            $ob->ssend('你想杀谁？');
            return false;
        }

        if ($me->query('id') == $target) {
            $ob->ssend('用 suicide 指令会比较快:P。');
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
        $callname = $RANK_D->query_rude($target);
        msg::message('vision', '$N对著$n喝道：「' . $callname . "！今日不是你死就是我活！」", $me, $target);
        $me->kill_ob($target);
        if ($target->is_player()) {
            $target->fight_ob($me);
            $target->get_conn()->ssend('如果你要和' . $me->query('name') .'性命相搏，请你也对这个人下一次 kill 指令。');
        }
        else {
            if (!$me->have_heart) 
                $me->set_heart_beat(1);
            if (!$target->have_heart)
                $target->set_heart_beat(1);
            $target->kill_ob($me);
        }
    }

    public function help() 
    {
        $ret = "这个指令让你主动开始攻击一个人物，并且□试杀死对方，kill 和 fight 最大的不同在於双方将会真刀实枪地打斗，也就是说，会真的受伤。由於 kill 只需单方面一厢情愿就可以成立，因此你对任何人使用 kill 指令都会开始战斗，通常如果对方是 NPC 的话，他们也会同样对你使用 kill。<br>当有人对你使用 kill 指令时会出现红色的字样警告你，对於一个玩家而言，如果你没有对一名敌人使用过 kill 指令，就不会将对方真的打伤或杀死( 使用法术除外)。<br>其他相关指令: fight";
        return $ret;
    }
}
