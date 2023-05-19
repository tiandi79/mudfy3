<?php
/**
*  技能查看
*
*/
namespace cmds\usr;

class skills
{
    public $skill_level_desc, $knowledge_level_desc;
    function __construct() 
    {   
        $this->skill_level_desc = array('初学乍练', '粗通皮毛', '半生不熟', '马马虎虎', '驾轻就熟', '出类拔萃', '神乎其技', '出神入化', '登峰造极', '一代宗师', '深不可测');
        $this->knowledge_level_desc = array('新学乍用', '初窥门径', '略知一二', '马马虎虎', '已有小成', '心领神会', '了然於胸', '豁然贯通', '举世无双', '震古铄今', '深不可测');
    }

    public function do_cmd($ob, $id = null)
    {
        $me = $ob->body;
        if (isset($id)) {
            $who = $me->is_environment($id);
            if (!isset($who)) {
                $ob->ssend('当前场景没有' . $id .'这个人。');
                return false;
            }

            if ($me->wizardp() || $me->is_apprentice_of($who) || null != $who->query('skill_public') || $me->is_couple($who)) {
                $ob->ssend('显示' . $who->name .'的技能');
                $this->ready_to_skills($who, $me);
            }
            else {
                $ob->ssend('只有管理或有师徒关系的人能察看他人的技能。');
                return false;
            }
        } else {
            $ob->ssend('显示自己的技能');
            $this->ready_to_skills($me, $me);
        }
    }

    public function ready_to_skills($obj, $me)
    {
        $ob = $me->get_conn();
        if (!$obj->query_skills()) {
            $ob->ssend((($obj == $me) ? '你' : $obj->name) .'目前并没有学会任何技能。');
        } else {
            global $CHINESE_D, $GAMESKILLS;
            $skills = $obj->query_skills();
            $ob->ssend((($obj == $me) ? '你' : $obj->name) .'目前共学过' . $CHINESE_D->chinese_number(count($skills)) . '种技能：');
            $enable_skills = $obj->query_skill_map();
            foreach ($skills as $k => $v) {
                $skill = $GAMESKILLS->get($k);
                $learnpoint = $obj->get_learnpoint($k);
                if ($enable_skills && in_array($k, $enable_skills))
                    $ob->ssend('*' . $skill->get_name() . '(' . $k . ')  - ' . $this->skill_level($skill->type, $v) . ' ' . $v . '/' . $learnpoint);
                else
                    $ob->ssend($skill->get_name() . '(' . $k . ')  - ' . $this->skill_level($skill->type, $v) . ' ' . $v . '/' . $learnpoint);
            }         
        }
    }

    public function skill_level($type, $level)
    {
        $grade = $level / 10;
        if ($type == 'normal') {
            if ($grade >= count($this->skill_level_desc))
				$grade = count($this->skill_level_desc) - 1;
			return $this->skill_level_desc[$grade];
        }
        elseif ($type == 'knowledge') {
            if ($grade >= count($this->knowledge_level_desc))
				$grade = count($this->knowledge_level_desc) - 1;
			return $this->knowledge_level_desc[$grade];
        }
        else
            return '未定义的';
    }

    public function help() 
    {
        $ret = "指令格式 : skills [<某人>]<br>这个指令可以让你查询所学过的技能。<br>你也可以指定一个和你有师徒关系的对象，用 skills 可以查知对方的技能状况。";
        return $ret;
    }
}
