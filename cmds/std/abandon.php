<?php
/**
*  忘记技能
*
*/
namespace cmds\std;

use std\msg;

class abandon
{
    function __construct()
    {
    }

    public function do_cmd($ob, $arg = null)
    {
        $me = $ob->body;
        if (null == $arg) {
            $ob->ssend('你要废除哪种技能？');
            return false;
        }

        $skills = $me->query_skills();
        if (!isset($skills[$arg])) {
            $ob->ssend('你好像并不会这种技能。');
            return false;
        }

        $enable_skills = $me->query_skill_map();
        if (in_array($arg, $enable_skills)) {
            $ob->ssend('你不能废除正在使用的特殊技能。');
            return false;
        }
        
        if ($me->del_skill($arg)) {
            global $GAMESKILLS;
            $skill = $GAMESKILLS->get($arg);
            $ob->ssend('你决定废除' . $skill->get_name() . '这项技能。');
            return true;
        } else {
            $ob->ssend('你废除' . $skill->get_name() . '这项技能失败。');
            return false;
        }
    }

    public function help() 
    {
        $ret = "指令格式：abandon <技能名称><br>放弃一项你所学的技能，注意这里所说的「放弃」是指将这项技能从你人物的资料中删除，如果你已後还要练，必须从 0 开始重练，请务必考虑清楚。";
        return $ret;
    }
}
