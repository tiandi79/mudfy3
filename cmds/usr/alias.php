<?php
/**
*  别名
* 
*/

namespace cmds\usr;

class alias
{
    function __construct() 
    {
    }

    public function do_cmd($ob, $s_cmd = null, $f_cmd = null, $f_cmd2 = null, $f_cmd3 = null, $f_cmd4 = null)
    {
        $me = $ob->body;
        $alias = $me->query_all_alias();
        if ($s_cmd == null && $f_cmd == null) {         
            if (count($alias) < 1) {
                $ob->ssend('你目前并没有设定任何 alias。');
                return false;
            }
            $ob->ssend('你目前设定的 alias 有：');
            foreach ($alias as $k => $v) {
                $ob->ssend($k . ' = ' .  $v);
            }
            return true;
        }
        $f_cmd = $f_cmd . ' ' . $f_cmd2 . ' ' . $f_cmd3. ' ' . $f_cmd4;

        if (trim($f_cmd) == '') {
            $me->del_alias($s_cmd);
            $ob->ssend('删除' . $s_cmd . '成功。');
            return true;
        } elseif ($s_cmd == 'alias') {
            $ob->ssend('不能设置alias的别名。');
            return false;
        }
        elseif (count($alias) > 9) {
            $ob->ssend('您最多只能建立10个alias。');
            return false;
        } else {
            $me->set_alias($s_cmd, $f_cmd);
            $ob->ssend('OK。');
            return true;
        }
    }

    public function help() 
    {
        $ret = "指令格式 : alias <欲设定之指令> <系统提供之指令><br>有时系统所提供之指令需要输入很长的字串, 在使用时(尤其是经常用到的)或许会感觉不方便, 此时你(玩家)即可用此一指令设定并替代原有之指令。<br>例:<br>	'alias sc score' 会以 sc 取代 score 指令。<br>	'alias' 後不加参数则列出你所有的替代指令。<br>	'alias sc' 会消除 sc 这个替代指令。 (如果你有设的话)";
        return $ret;
    }
}
