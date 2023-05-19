<?php
/**
*  基础资料查看
*
*/
namespace cmds\usr;

class score
{
    function __construct() 
    {

    }

    public function do_cmd($ob, $who = null)
    {
        global $CHINESE_D;
        $user = $ob->body;
        if (isset($who) && $ob->body->wizardp()) {
            $me = $ob->body;
            if ($me->is_environment($who)) {
                $who = $me->is_environment($who);
                $ob->ssend('显示' . $who->name .'的状态');
                $ob->ssend('你是一' . $who->query('unit') . $who->query('national') . $CHINESE_D->chinese_number($who->query('age')) . '岁的' . $who->query('gender') . $who->query('race') . ',' . $CHINESE_D->chinese_date(intval($who->query('birthday') - 10*365*24*60*60)) . '生。');
                if (isset($who->family['master_name']))
                    $ob->ssend('你的师父是' . $who->family['master_name']);
                $ob->ssend('才智：' . $who->query('int') . '/' . $who->query_attr('int') . ' 体质：' . $who->query('con') . '/' . $who->query_attr('con'));
                $ob->ssend('灵性：' . $who->query('spi') . '/' . $who->query_attr('spi') . ' 魅力：' . $who->query('per') . '/' . $who->query_attr('per'));
                $ob->ssend('勇气：' . $who->query('cor') . '/' . $who->query_attr('cor') . ' 力量：' . $who->query('str') . '/' . $who->query_attr('str'));
                $ob->ssend('耐力：' . $who->query('dur') . '/' . $who->query_attr('dur') . ' 韧性：' . $who->query('fle') . '/' . $who->query_attr('fle'));
                $ob->ssend('速度：' . $who->query('agi') . '/' . $who->query_attr('agi') . ' 气量：' . $who->query('tol') . '/' . $who->query_attr('tol'));
                $ob->ssend('运气：' . $who->query('kar') . '/' . $who->query_attr('kar') . ' 定力：' . $who->query('cps') . '/' . $who->query_attr('cps'));

                if (null != $who->query_temp('weapon')) {
                    $weapon = $who->query_temp('weapon');
                    $skill_type = $weapon->skill_type;
                    $parry_type = "parry";
                }	
                else
                {
                    $skill_type = "unarmed";
                    $parry_type = "unarmed";
                }
                
                global $COMBAT_D;
                $attack_points = $COMBAT_D->skill_power($who, $skill_type, SKILL_USAGE_ATTACK);
                $parry_points = $COMBAT_D->skill_power($who, $parry_type, SKILL_USAGE_DEFENSE);
                $dodge_points = $COMBAT_D->skill_power($who, 'dodge', SKILL_USAGE_DEFENSE);

                if (!isset($weapon))
                    $parry_points = $parry_points / 2;

                $ob->ssend('攻击力：' . intval($attack_points + 1) . ' 防御力：' . intval($dodge_points/2 + $parry_points + 1));
                $ob->ssend('杀伤力：' . intval($who->query_temp('apply/damage')) . ' 保护力：' . intval($who->query_temp('apply/armor')));
            } else {
                $ob->ssend('当前场景没有' . $who .'这个人。');
            }            
        }
        else {
            $user = $ob->body;
            $ob->ssend('显示自己的基础资料');
            $ob->ssend('你是一' . $user->query('unit') . $user->query('national') . $CHINESE_D->chinese_number($user->query('age')) . '岁的' . $user->query('gender') . $user->query('race') . ',' . $CHINESE_D->chinese_date(intval($user->query('birthday') - 10*365*24*60*60)) . '生。');
            $ob->ssend('你总共杀了' . $CHINESE_D->chinese_number($user->query('mks')) . '个人，' . $CHINESE_D->chinese_number($user->query('pks')) . '个玩家，被杀了' .$CHINESE_D->chinese_number($user->query('killed')) . '次。');
            $ob->ssend('你到目前为止总共完成了' .$CHINESE_D->chinese_number($user->query('task')) . '个使命。');
            if (isset($user->family['master_name']))
                $ob->ssend('你的师父是' . $user->family['master_name'] . '。');
                $ob->ssend('才智：' . $user->query('int') . '/' . $user->query_attr('int') . ' 体质：' . $user->query('con') . '/' . $user->query_attr('con'));
                $ob->ssend('灵性：' . $user->query('spi') . '/' . $user->query_attr('spi') . ' 魅力：' . $user->query('per') . '/' . $user->query_attr('per'));
                $ob->ssend('勇气：' . $user->query('cor') . '/' . $user->query_attr('cor') . ' 力量：' . $user->query('str') . '/' . $user->query_attr('str'));
                $ob->ssend('耐力：' . $user->query('dur') . '/' . $user->query_attr('dur') . ' 韧性：' . $user->query('fle') . '/' . $user->query_attr('fle'));
                $ob->ssend('速度：' . $user->query('agi') . '/' . $user->query_attr('agi') . ' 气量：' . $user->query('tol') . '/' . $user->query_attr('tol'));
                $ob->ssend('运气：' . $user->query('kar') . '/' . $user->query_attr('kar') . ' 定力：' . $user->query('cps') . '/' . $user->query_attr('cps'));     
            $ob->ssend('自造物品：' . $user->query('created_item') . ' 自造房间：' . $user->query('created_room'));

            if (null != $user->query_temp('weapon')) {
                $weapon = $user->query_temp('weapon');
                $skill_type = $weapon->skill_type;
                $parry_type = "parry";
            }	
            else
            {
                $skill_type = "unarmed";
                $parry_type = "unarmed";
            }
            
            global $COMBAT_D;
            $attack_points = $COMBAT_D->skill_power($user, $skill_type, SKILL_USAGE_ATTACK);
	        $parry_points = $COMBAT_D->skill_power($user, $parry_type, SKILL_USAGE_DEFENSE);
	        $dodge_points = $COMBAT_D->skill_power($user, 'dodge', SKILL_USAGE_DEFENSE);

            if (!isset($weapon))
                $parry_points = $parry_points / 2;

            $ob->ssend('攻击力：' . intval($attack_points + 1) . ' 防御力：' . intval($dodge_points/2 + $parry_points + 1));
            $ob->ssend('杀伤力：' . intval($user->query_temp('apply/damage')) . ' 保护力：' . intval($user->query_temp('apply/armor')));
            $ob->ssend('参数点：' . $user->query('gift_points'));
        }
    }

    public function help() 
    {
        $ret = "指令格式 : score<br>这个指令可以显示你的基础资料.";
        return $ret;
    }
}
