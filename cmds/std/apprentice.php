<?php
/**
*  拜师
*
*/
namespace cmds\std;

use std\msg;

class apprentice
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null, $sena = null)
    {
        $me = $ob->body;

        if ($me->is_fighting()) {
            $ob->ssend('你无法在战斗中进行拜师！');
            return false;
        }

        if (!isset($arg)) {
            $ob->ssend('指令格式：apprentice [cancel]|<对象>');
            return false;
        }

        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成！');
            return false;
        }

        if ($arg == 'cancel') {
            $old_app = $me->query_temp('pending/apprentice');
            if (null == $old_app) {
                $ob->ssend('你现在并没有拜任何人为师的意思。');
                return false;
            }
            $ob->ssend('你改变主意不想拜' + $old_app->name . '为师了。');
            $me->del_temp('pending/apprentice');
        }

        if (!$master = $me->is_environment($arg)) {
            $ob->ssend('你想拜谁为师？');
            return false;
        }
        else {
            if (!$master->is_character()) {
                $ob->ssend('你想拜谁为师？');
                return false;
            }

            if (!$master->living()) {
                $ob->ssend('你必须先把' . $master->name . '弄醒。');
                return false;
            }

            if ($master == $me) {
                $ob->ssend('拜自己为师？好主意....不过没有用。');
                return false;
            }

            if ($me->is_apprentice_of($master)) {
                msg::message('vision', '$N恭恭敬敬地向$n磕头请安，叫道：「师父！」', $me, $master);
                if (method_exists($master, 're_rank')) 
                    $master->re_rank($me);
                return true;
            }

            if (null == $master->query("family")) {
                $ob->ssend($master->name . '既不属於任何门派，也没有开山立派，不能拜师。');
                return false;
            }
            
            $master_family = $master->query("family");
            $me_family = $me->query("family");

            if ($master->is_player() && $master_family['privs'] != -1) {
                $ob->ssend('不是掌门人不可收徒．');
                return false;
            }

            if (($me_family != null && $me_family['family_name'] == $master_family['family_name']) 
                && ($m_family['generation'] <= $master_family['generation'])) {
                $ob->ssend($master->name . '的辈分并不比你高');
                return false;
            }

            if ($master->query_temp("pending/recruit") == $me) {
                if ($me_family != null && $me_family['family_name'] != $master_family['family_name']) {
			        msg::message('vision', '$N决定背叛师门，改投入$n门下！！<br>$N跪了下来向$n恭恭敬敬地磕了四个响头，叫道：「师父！」', $me, $master);
                    $me->set("score", 0);
			        $me->add("betrayer", 1);
                } else {
                    msg::message('vision', '$N决定拜$n为师。<br>$N跪了下来向$n恭恭敬敬地磕了四个响头，叫道：「师父！」', $me, $master);
                }         
                $master->recruit_apprentice($me);
                $master->del_temp("pending/recruit");
                if ($master->is_player()) {
                    $master->get_conn->ssend('恭喜你新收了一名弟子！');
                }
                $family = $me->query("family");
                global $CHINESE_D;
		        $ob->ssend('恭喜您成为' . $family['family_name'] . '的第' . $CHINESE_D->chinese_number($family['generation']) . '代弟子。');
            } else {
                $old_app = $me->query_temp("pending/apprentice");
                if ($master == $old_app) {
                    $ob->ssend('你想拜' . $master->name . '为师，但是对方还没有答应。');
                    return false;
                }
                if ($old_app)
                    $ob->ssend('你改变主意不想拜' . $old_app->name . '为师了。');
                msg::message('vision', '$N想要拜$n为师。', $me, $master);
                $me->set_temp("pending/apprentice", $master);
                if ($master->is_player()) {
                    $master->get_conn->ssend(YEL . '如果你愿意收' . $me->name . '为弟子，用 recruit 指令。' . NOR);
                }
                else
                    $master->attempt_apprentice($me);
            }
        }
        return true;
    }

    public function help() 
    {
        $ret = "指令格式 : apprentice [cancel]|<对象><br>这个指令能让你拜某人为师，如果对方也答应要收你为徒的话，就会立即行拜师之礼，否则要等到对方用 recruit 指令收你为弟子才能正式拜师。请注意你已经有了师父，又背叛师门投入别人门下，所有技能可能会减半，并且评价会降到零。<br>如果对你的师父使用这个指令，会变成向师父请安，并要求师父给你个合适的称号。<br>请参考相关指令 expell、recruit";
        return $ret;
    }
}
