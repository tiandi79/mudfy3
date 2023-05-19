<?php
/**
*  收徒
*
*/
namespace cmds\std;

use std\msg;

class recruit
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null, $sena = null)
    {
        $me = $ob->body;

        if ($me->is_fighting()) {
            $ob->ssend('你无法在战斗中进行收徒！');
            return false;
        }

        if (!isset($arg)) {
            $ob->ssend('指令格式：recruit [cancel]|<对象>');
            return false;
        }

        if ($me->is_busy()) {
            $ob->ssend('你上一个动作还没有完成！');
            return false;
        }

        if ($arg == 'cancel') {
            $old_app = $me->query_temp('pending/recruit');
            if (null == $old_app) {
                $ob->ssend('你现在并没有收任何人为徒的意思。');
                return false;
            }
            $ob->ssend('你改变主意不想收' + $old_app->name . '为徒了。');
            $me->del_temp('pending/apprentice');
        }

        if (!$apprentice = $me->is_environment($arg)) {
            $ob->ssend('你想收谁为徒？');
            return false;
        }
        else {
            if (!$apprentice->is_character()) {
                $ob->ssend('你想收谁为徒？');
                return false;
            }

            if (!$apprentice->living()) {
                $ob->ssend('你必须先把' . $apprentice->name . '弄醒。');
                return false;
            }

            if ($apprentice == $me) {
                $ob->ssend('收自己为徒？好主意....不过没有用。');
                return false;
            }

            if ($apprentice->is_apprentice_of($me)) {
                $ob->ssend('$N拍拍$n的头，说道：「好徒儿！」');
                return true;
            }

            $apprentice_family = $apprentice->query("family");
            $me_family = $me->query("family");

            if (null == $me_family) {
                $ob->ssend('你并不属於任何门派，你必须先加入一个门派，或自己创一个才能收徒。');
                return false;
            }

            if ($me->is_player() && $me_family['privs'] != -1) {
                $ob->ssend('不是掌门人不可收徒．');
                return false;
            }

            if (($apprentice_family != null && ($me_family['family_name'] == $apprentice_family['family_name'])) 
                && ($me_family['generation'] >= $apprentice_family['generation'])) {
                $ob->ssend($apprentice->name . '的辈分并不比你低');
                return false;
            }

            if ($apprentice->query_temp("pending/apprentice") == $me) {
                if ($apprentice_family != null && ($me_family['family_name'] != $apprentice_family['family_name'])) {
			        msg::message('vision', '$N决定背叛师门，改投入$n门下！！<br>$N跪了下来向$n恭恭敬敬地磕了四个响头，叫道：「师父！」', $apprentice, $me);
                    $apprentice->set("score", 0);
			        $apprentice->add("betrayer", 1);
                } else {
                    msg::message('vision', '$N决定拜$n为师。<br>$N跪了下来向$n恭恭敬敬地磕了四个响头，叫道：「师父！」', $apprentice, $me);
                }         
                $me->recruit_apprentice($apprentice);
                $apprentice->del_temp("pending/apprentice");
                if ($me->is_player()) {
                    $ob->ssend('恭喜你新收了一名弟子！');
                }
                $family = $apprentice->query("family");
                global $CHINESE_D;
                if ($apprentice->is_player())
		            $apprentice->get_conn()->ssend('恭喜您成为' . $family['family_name'] . '的第' . $CHINESE_D->chinese_number($family['generation']) . '代弟子。');
            } else {
                $old_app = $me->query_temp("pending/recruit");
                if ($apprentice == $old_app) {
                    $ob->ssend('你想收' . $apprentice->name . '为徒，但是对方还没有答应。');
                    return false;
                }
                if ($old_app)
                    $ob->ssend('你改变主意不想收' . $old_app->name . '为徒了。');
                msg::message('vision', '$N想要拜$n为师。', $me, $apprentice);
                $me->set_temp("pending/recruit", $apprentice);
                if ($apprentice->is_player()) {
                    $apprentice->get_conn->ssend(YEL . '如果你愿意拜' . $me->name . '为师，用 apprentice 指令。' . NOR);
                }
            }
        }
        return true;
    }

    public function help() 
    {
        $ret = "指令格式 : recruit [cancel]|<对象><br>这个指令能让你收某人为弟子, 如果对方也答应要拜你为师的话.";
        return $ret;
    }
}
