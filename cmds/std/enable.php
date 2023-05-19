<?php
/**
*  使用特殊技能
*
*/
namespace cmds\std;

use std\msg;

class enable
{
    public $valid_types = array('axe' => '斧法', 'blade' => '刀法', 'dagger' => '短兵刃', 'dodge' => '闪躲术', 'force' => '内功', 'fork' => '叉法', 'hammer' => '锤法', 'iron-cloth' => '硬功', 'literate' => '读写', 'magic' => '法术', 'move' => '轻功', 'parry' => '招架', 'perception' => '听风术', 'scratching' => '符之术', 'cursism' => '降头术', 'spells' => '咒术', 'staff' => '杖法', 'stealing' => '妙手术', 'sword' => '剑法', 'throwing' => '暗器', 'unarmed' => '拳脚', 'whip' => '鞭法', 'herb' => '药道', 'spear' => '枪法');
    function __construct()
    {
    }

    public function do_cmd($ob, $skill = null, $enableskill = null)
    {
        $me = $ob->body;
        global $GAMESKILLS;
        if (!isset($skill)) {
            if (!$me->query_skill_map()) {
                $ob->ssend('你现在没有使用任何特殊技能。');
                return false;
            }
            else {
                $ob->ssend('以下是你目前使用中的特殊技能。');
                $enable_skills = $me->query_skill_map();
                foreach ($enable_skills as $k => $v) {
                    $flag = false;
                    $basic_skill = $GAMESKILLS->get($k);
                    $enable_skill = $GAMESKILLS->get($v);
                    if (null != ($me->query_temp('apply/' . $skill)))
                        $flag = true;
                    $ob->ssend($basic_skill->get_name() . '(' . $k . ') ' . $enable_skill->get_name() . '(' . $v . ') ' . '- 有效等级 ' . ($flag ? 'CYN' : '') . $me->query_skill($k) . ($flag ? 'NOR' : ''));
                }
                return true;
            }
        } else {
            if (!array_key_exists($skill, $this->valid_types)) {
                $ob->ssend('没有这个技能种类。');
                return false;
            }
            if (isset($enableskill)) {
                if ($enableskill == 'none') {
                    $me->map_skill($skill);
                    $me->reset_action();
                    $ob->ssend('OK.');
                    return true;
                }
                else {
                    if ($me->query_skill($enableskill, 1) == 0) {
                        $ob->ssend('你还不会这项特殊技能。');
                        return false;
                    }
                    else {
                        $me->map_skill($skill, $enableskill);
                        $me->reset_action();
                        $ob->ssend('OK.');

                        if ($skill == 'magic') {
                            $ob->ssend('你改用另一种法术系，灵力必须重新锻炼。');
                            $me->set('atman', 0);
                            $me->receive_damage('gin', 0);
                        } elseif ($skill == 'force') {
                            $ob->ssend('你改用另一种内功，内力必须重新锻炼。');
                            $me->set('force', 0);
                            $me->receive_damage('kee', 0);
                        } elseif ($skill == 'spells') {
                            $ob->ssend('你改用另一种咒文系，法力必须重新修炼。');
                            $me->set('mana', 0);
                            $me->receive_damage('sen', 0);
                        } 
                        return true;
                    }
                }
            } else {
                $basic_skill = $GAMESKILLS->get($skill);
                if ($me->query_skill_mapped($skill))
                    $enable_skill = $GAMESKILLS->get($me->query_skill_mapped($skill));
                else
                    $enable_skill = false;

                if (!$enable_skill) {
                    $ob->ssend('你的' . $basic_skill->get_name() . '并没有使用特殊技能。');
                    return false;
                } else {
                    $ob->ssend('以下是你目前' . $basic_skill->get_name() . '的特殊技能。');
                    $flag = false;
                    if (null != ($me->query_temp('apply/' . $skill))) {
                        $flag = true;
                        echo 'tmp =' . $me->query_temp('apply/' . $skill);
                    }
                    $ob->ssend($basic_skill->get_name() . '(' . $skill . ') ' . $enable_skill->get_name() . '(' . $me->skills_enable[$skill] . ') ' . '- 有效等级 ' . ($flag ? 'CYN' : '') . $me->query_skill($skill) . ($flag ? 'NOR' : ''));
                    return true;
                }
            }
        }
    }

    public function help() 
    {
        $ret = "enable [<技能种类> <技能名称> | none]<br>这个指令让你指定所要用的技能，需指明技能种类和技能名称。如果不加参数则会显示出技能种类及你目前所使用的技能名称 ，如果加一个 ? 会列出所有能使用特殊技能的技能种类。";
        return $ret;
    }
}
