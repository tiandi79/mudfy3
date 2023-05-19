<?php
/**
*  角色定义
*
*/

namespace std;

use std\msg;
use \Workerman\Lib\Timer;

class char extends obj
{
    public $id = 'npc';
    public $name = '未知角色';
    public $title = '';
    public $gender = '男性';
    public $place;
    public $skills;
    public $skills_enable;
    public $learnpoint;
    public $alias;
    public $type = 'char';
    public $combat_exp = 0;
    public $enemy = array();
    public $conditions = array();
    public $weight = 40000;
    public $food = 0;
    public $water = 0;
    public $is_busy = 0;
    public $have_heart = true;
      
    function __construct($user = null) 
    {
        parent::__construct();
        global $CHAR_D;
        if (isset($user))
            $CHAR_D->setup_char($user);
        else
            $CHAR_D->setup_char($this);
        $this->is_live = true;
        $this->is_character = true;
        $this->set('score', 0);
        $this->set('atman', 0);
        $this->set('max_atman', 0);
        $this->set('force', 0);
        $this->set('max_force', 0);
        $this->set('mana', 0);
        $this->set('max_mana', 0);
        $this->set('potential', 0);
        $this->set('bellicosity', 0);
        $this->set('no_get', 1);
    }

    public function get_conn()
    {
        if ($this->is_player()) {
            global $GAME;
            if (isset($GAME->users[$this->uid]))
                return $GAME->users[$this->uid];
        } else {
            global $DEFAULT_CONN;
            $DEFAULT_CONN->init($this);
            return $DEFAULT_CONN;
        }
    }

    /* 转换PHP内部函数 */
    private function adjust_cmd($command)
    {
        if ($command == 'goto')
            return 'ggoto';
        elseif ($command == 'clone')
            return 'cclone';
        else
            return $command;
    }

    public function do_cmd($ob, $command)
    {
        $command = $this->convertalias($command);
        $cmds = explode(" ", $command);

        if (in_array($cmds[0], array('new', 'new*', 'chat', 'chat*', 'fy', 'fy*', 'rumor', 'rumor*', 'wiz', 'sys')) && isset($cmds[1])) {
            msg::channel($cmds[0], $cmds[1], $ob);
            return true;
        }

        /* 先调用动态动作 */
        if ($this->load_actions($ob, $cmds)) {
            return true;
        }
        else {
            /* 调用系统命令 */
            $cmds[0] = $this->adjust_cmd($cmds[0]);
            $usrfile = self::get_cmd_file($cmds[0], 'usr');
            $stdfile = self::get_cmd_file($cmds[0], 'std');
            $wizfile = self::get_cmd_file($cmds[0], 'wiz');

            if (file_exists($usrfile) || file_exists($stdfile) || file_exists($wizfile)) {
                $final_cmd = strtoupper($cmds[0]) . "_CMD";
                global $$final_cmd;
                if (isset($cmds[5])) {
                    $ob->ssend('命令行里参数过多。');
                    return true;
                }
                elseif (isset($cmds[4]))
                    $$final_cmd->do_cmd($ob, $cmds[1], $cmds[2], $cmds[3], $cmds[4]);
                elseif (isset($cmds[3]))
                    $$final_cmd->do_cmd($ob, $cmds[1], $cmds[2], $cmds[3]);
                elseif (isset($cmds[2]))
                    $$final_cmd->do_cmd($ob, $cmds[1], $cmds[2]);
                elseif (isset($cmds[1]))
                    $$final_cmd->do_cmd($ob, $cmds[1]);
                else
                    $$final_cmd->do_cmd($ob);
                return true;
            }
            return false;
        }
    }

    /* 动态动作 */
    public function load_actions($ob, $cmds)
    {
        $cmds[0] = 'do_' . $cmds[0];
        $para1 = isset($cmds[1]) ? $cmds[1] : null;
        $para2 = isset($cmds[2]) ? $cmds[2] : null;
        $para3 = isset($cmds[3]) ? $cmds[3] : null;
        $para4 = isset($cmds[4]) ? $cmds[4] : null;
        /* 先检查自己身上的物件 */
        $objs = $this->all_inventory();
        if (null != $objs) {
            foreach ($objs as $v) {
                if (method_exists($v, $cmds[0])) {
                    $cmd = $cmds[0];
                    if ($v->$cmd($ob, $para1, $para2, $para3, $para4))
                        return true;
                }
            }
        }

        /* 检查当前场景 */
        $room = $this->get_env();
        if (method_exists($room, $cmds[0])) {
            $cmd = $cmds[0];
            return $room->$cmd($ob, $para1, $para2, $para3, $para4);
        }
        else {
            $objs = $room->all_inventory();
            if (null != $objs) {
                foreach ($objs as $v) {
                    if ($v->is_player())
                        continue;
                    if (method_exists($v, $cmds[0])) {
                        $cmd = $cmds[0];
                        if ($v->$cmd($ob, $para1, $para2, $para3, $para4))
                            return true;
                    }
                }
            }     
        }
        /* 找不到action */
        return false;
    }

    private function get_cmd_file_path($path)
    {
        return ROOT_DIR . 'cmds/' . $path .'/';
    }

    public function get_cmd_file($command, $path)
    {
        return $this->get_cmd_file_path($path) . $command .'.php';
    }

    public function max_food_capacity()
    {
        return 100;
    }

    public function max_water_capacity()
    {
        return 100;
    }

    public function heart_beat()
    {
        if ($this->is_player()) {
            $this->update_age();
            if ($this->query('last_save') == null || $this->query('last_save') + AUTOSAVE < time()) {
                $this->set('last_save', time());
                $this->save();
                $this->get_conn()->ssend('自动保存档案。');
            } 
        }

        if ($this->query('kee') < 0) {
            $this->die();
            $this->remove_all_enemy();
            return false;
        }

        if ($this->query_temp('is_unconcious') != null) {
            return false;
        }

        if ($this->query('gin') < 0 || $this->query('sen') < 0) {
            $this->unconcious();
            $this->remove_all_enemy();
            return false;
        }  
        
        /* 处理conditions */
        $conditions = $this->get_conditions();

        if (count($conditions) > 0) {
            foreach ($conditions as $k => $v) {
                if ($v['next_time'] <= time()) {
                    $this_class = $v['this_class'];
                    $func = $v['func'];
                    $param = $v['param'];
                    $this_class->$func($this, $param);
                    unset($this->conditions[$k]);
                }
            }
        }
        if ($this->is_fighting()) {
            if (!$this->auto_combat_perform()) {
                attack::attack_init($this);
            }
        }
        else {
            $this->chating();

            /* 同场景有仇家自动战斗 */
            $envs = $this->get_env()->all_inventory();
            $flag = false;
            foreach ($envs as $k => $v) {
                if (null != $v->query_temp('killer')) {
                    $killers = $v->query_temp('killer');
                    foreach ($killers as $kk => $vv) {
                        if ($vv == $this) {
                            global $COMBAT_D;
                            $COMBAT_D->start_hatred($v, $this);
                            $this->fight_ob($v);
                            $flag = true;
                        }
                    }
                }
            }
            if ($flag) {
                attack::attack_init($this);
            }
        }
        //npc不需要heal_up
        if ($this->is_player() && ($this->query('last_heal_up') == null || ($this->query('last_heal_up') + HEAL_UP_RATIO) < time()))
            $this->heal_up();

        //guard需要heal_up
        if ($this->id == 'guard' && $this->name == '大内高手' && !$this->is_fighting()) {
            $this->heal_up();
        }
    }

    public function heal_up()
    {
        $this->set('last_heal_up', time());
        $has_water = false;
        $has_food = false;
        if ($this->query('water') > 0) {
            $this->set('water', $this->query('water') - 1);
            $has_water = true;
        }

        if ($this->query('food') > 0) {
            $this->set('food', $this->query('food') - 1);
            $has_food = true;
        }

        if ($has_water && $has_food) {
            $i = 1;
            if ($this->query_temp('in_dazuo') != null)
                $i = 2;

            $this->set('gin', intval($this->query('gin') + ($this->query('spi') + $this->query('atman') / 10) * $i));
	        if ($this->query('gin') > $this->query('eff_gin')) {
		        $this->set('gin', $this->query('eff_gin'));
                if ($this->query('eff_gin') < $this->query('max_gin'))
                    $this->set('eff_gin', $this->query('eff_gin') + 1);
            }

            $this->set('kee', intval($this->query('kee') + ($this->query('con') + $this->query('force') / 10) * $i));
	        if ($this->query('kee') > $this->query('eff_kee')) {
		        $this->set('kee', $this->query('eff_kee'));
                if ($this->query('eff_kee') < $this->query('max_kee'))
                    $this->set('eff_kee', $this->query('eff_kee') + 1);
            }

            $this->set('sen', intval($this->query('sen') + ($this->query('int') + $this->query('mana') / 10) * $i));
	        if ($this->query('sen') > $this->query('eff_sen')) {
		        $this->set('sen', $this->query('eff_sen'));
                if ($this->query('eff_sen') < $this->query('max_sen'))
                    $this->set('eff_sen', $this->query('eff_sen') + 1);
            }

	        if ($this->query('atman') < $this->query('max_atman')) {
		        $this->set('atman', intval($this->query_skill('magic', 1) / 2 * $i));
                if ($this->query('atman') > $this->query('max_atman'))
                    $this->set('atman', $this->query('max_atman'));
            }

	        if ($this->query('force') < $this->query('max_force')) {
		        $this->set('force', intval($this->query_skill('force', 1) / 2 * $i));
                if ($this->query('force') > $this->query('max_force'))
                    $this->set('force', $this->query('max_force'));
            }

	        if ($this->query('mana') < $this->query('max_mana')) {
		        $this->set('mana', intval($this->query_skill('spells', 1) / 2 * $i));
                if ($this->query('mana') > $this->query('max_mana'))
                    $this->set('mana', $this->query('max_mana'));
            }
            return true;
        }
        else {
            return false;
        }
    }

    public function equip_object($key)
    {
        global $OBJECT;
        $obj = $OBJECT->create_objects($key);
        $obj->move($this);
        return $this->equip($obj);
    }

    public function equip($obj, $type = null)
    {
        if (!isset($type) || $type == 'wear') { 
            if ($obj->query('type') == 'cloth' || $obj->query('type') == 'head' || $obj->query('type') == 'mask' || $obj->query('type') == 'boots' || $obj->query('type') == 'ring' || $obj->query('type') == 'wrists' || $obj->query('type') == 'neck' || $obj->query('type') == 'waist' || $obj->query('type') == 'hand') {
                $type = $obj->query('type');
                $this->set_temp('armor/' . $type, $obj);
                $this->set_temp('apply/armor', $this->query_temp('apply/armor') + $obj->armor_prop_armor);
                $this->set_temp('apply/dodge', $this->query_temp('apply/dodge') + $obj->armor_prop_dodge);
                $this->set_temp('apply/move', $this->query_temp('apply/move') + $obj->armor_prop_move);
                if ($type == 'mask') {
                    $this->set_temp('apply/id', $obj->query('fakeid'));
                    $this->set_temp('apply/name', $obj->query('fakename'));
                    $this->set_temp('apply/gender', $obj->query('fakegender'));
                }
                $obj->set('equipped', 1);
                return true;
            }
        }
        if (!isset($type) || $type == 'wield') { 
            if ($obj->query('type') == 'sword' || $obj->query('type') == 'blade' || $obj->query('type') == 'whip' 
                || $obj->query('type') == 'dagger' || $obj->query('type') == 'staff' || $obj->query('type') == 'throwing' || $obj->query('type') == 'hammer') {
                $this->set_temp('weapon', $obj);
                $this->set_temp('apply/damage', $this->query_temp('apply/damage') + $obj->weapon_prop);
                $obj->set('equipped', 1);
                return true;
            }
        }
        return false;
    }

    public function unequip($obj, $type = null)   
    {
        if (!isset($type) || $type == 'remove') { 
            if ($obj->query('type') == 'cloth' || $obj->query('type') == 'head' || $obj->query('type') == 'mask' || $obj->query('type') == 'boots' || $obj->query('type') == 'ring' || $obj->query('type') == 'wrists' || $obj->query('type') == 'neck' || $obj->query('type') == 'waist' || $obj->query('type') == 'hand') {
                $type = $obj->query('type');
                $this->del_temp('armor/' . $type, $obj);
                $this->set_temp('apply/armor', $this->query_temp('apply/armor') - $obj->armor_prop_armor);
                $this->set_temp('apply/dodge', $this->query_temp('apply/dodge') - $obj->armor_prop_dodge);
                $this->set_temp('apply/move', $this->query_temp('apply/move') - $obj->armor_prop_move);
                if ($type == 'mask') {
                    $this->del_temp('apply/id');
                    $this->del_temp('apply/name');
                    $this->del_temp('apply/gender');
                }
                $obj->set('equipped', null);   
                return true; 
            }
        }
        if (!isset($type) || $type == 'unwield') { 
            if ($obj->query('type') == 'sword' || $obj->query('type') == 'blade' || $obj->query('type') == 'whip' 
                || $obj->query('type') == 'dagger' || $obj->query('type') == 'staff' || $obj->query('type') == 'throwing' || $obj->query('type') == 'hammer') {
                $this->del_temp('weapon', $obj);
                $this->set_temp('apply/damage', $this->query_temp('apply/damage') - $obj->weapon_prop);
                $obj->set('equipped', null);   
                return true; 
            }
        }
        return false;
    }

    public function wizardp()
    {
        if (null != $this->query('level') && $this->query('level') == 'wizard')
            return true;
        else
            return false;
    }

    public function accept_fight($ob = null)
    {
        $att = $this->query("attitude");
        if ($this->is_fighting()) {
            switch($att) {
		        case "heroism":
			        msg::message_text('say', 'say 哼！出招吧！', $this);
                    break;
                default:
                    msg::message_text('say', 'say 想倚多为胜，这不是欺人太甚吗！', $this);
                    return false;
            }
        }
        global $RANK_D;
        if (($this->query("gin") * 100 / $this->query("max_gin")) >= 90
	        &&	($this->query("kee") * 100 / $this->query("max_kee")) >= 90
	        &&	($this->query("sen") * 100 / $this->query("max_sen")) >= 90) {
            switch($att) {
                case "friendly":
                    msg::message_text('say', $RANK_D->query_self($this) . '怎么可能是' . $RANK_D->query_respect($ob) . '的对手？', $this);
                    return false;
                    break;
                case "aggressive":
                case "killer":
                    msg::message_text('say', '哼！出招吧！', $this);
                    break;
                default:
                    if (!$this->is_fighting()) 
                        msg::message_text('say', '既然' . $RANK_D->query_respect($ob) . '赐教，' . $RANK_D->query_self($this) . '只好奉陪。', $this);
            }
            return true;
        }
        return false;
    }

    public function set_heart_beat($flag = 1)
    {
        $this->have_heart = $flag;
    }

    public function is_couple($obj)
    {
        if (null == $this->query('couple'))
            return false;
        $couple = $this->query('couple');
        if ($couple['id'] == $obj->id)
            return true;
        else
            return false;
    }

    public function is_apprentice_of($obj)
    {
        if (!$obj)
            return false;

        if (null == $obj->query('family'))
            return false;
        else {
            $obj_family_info = $obj->query('family');
            if (null == $this->query('family'))
                return false;
            else
                $my_family_info = $this->query('family');
            if (($obj->name == $this->family['master_name']) && ($obj->id = $this->family['master_id']) && ($obj_family_info['family_name'] == $my_family_info['family_name']))
                return true;
            else
                return false;
        }
    }

    public function set_skill($skill, $value)
    {
        $this->skills[$skill] = $value;
    }

    public function query_skills()
    {
        if (!isset($this->skills) || count($this->skills) == 0)
            return false;

        return $this->skills;
    }

    public function del_skill($skill)
    {
        if (isset($this->skills) && ($this->skills[$skill] != null)) {
            $temp_skills = $this->skills;
            unset($temp_skills[$skill]);
            $this->skills = $temp_skills;
            return true;
        }
        return false;
    }

    public function get_learnpoint($skill)
    {
        if (!isset($this->learnpoint[$skill]))
            return 0;
        else
            return $this->learnpoint[$skill];
    }

    public function add_learnpoint($skill, $amount)
    {
        if (!isset($this->skills[$skill]))
            $this->skills[$skill] = 0;

        if (isset($this->learnpoint[$skill]))
            $this->learnpoint[$skill] += $amount;
        else
            $this->learnpoint[$skill] = $amount;
        return $this->learnpoint[$skill];
    }

    public function set_learnpoint($skill, $amount)
    {
        return $this->learnpoint[$skill] = $amount;
    }   

    public function query_skill($skill, $raw = null)
    {
        $s = 0;
        if (!isset($raw)) {
            /* 临时加属性技能 */
            if (null != ($this->query_temp('apply/' . $skill)))
                $s = $this->query_temp('apply/' . $skill);
            
            /* 如果有该基础技能 */
            if (isset($this->skills[$skill]))
                $s += intval($this->skills[$skill] / 2);

            /* 如果该技能有特殊技能 */
            if (isset($this->skills_enable[$skill])) {
                global $GAMESKILLS;
                $enable_skill = $this->skills_enable[$skill];
                $skill_class = $GAMESKILLS->get($skill);
                if (!method_exists($skill_class, 'effective_level'))
                    $eff = 5;
                else
                    $eff = $skill_class->effective_level();
                $level = $this->skills[$enable_skill] * $eff / 10;
            }
            else
                $level = 0;
            
            $s += $level;   
        } else {
            if (isset($this->skills[$skill]))
                $s = $this->skills[$skill];
            else
                $s = 0;
        }
        return $s;
    }

    public function map_skill($skill, $enableskill = null)
    {
        if ($this->query_skill($skill) && $enableskill == null) {
            unset($this->skills_enable[$skill]);
            return true;
        }

        /*if (isset($this->skills_enable[$skill])) {
            $this->get_conn()->ssend('这个技能种类已经指定了特殊技能。');
            return false;
        }*/
        global $GAMESKILLS;
        $this_enableskill = $GAMESKILLS->get($enableskill);
        if ($this_enableskill->valid_enable($skill)) {
            $this->skills_enable[$skill] = $enableskill;
            return true;
        }
        else {
            $this->get_conn()->ssend('这个技能种类不能使用该特殊技能。');
            return false;
        }
    }

    public function query_skill_map()
    {
        if ($this->skills_enable == null && count($this->skills_enable) == 0)
            return false;
        else
            return $this->skills_enable;
    }
    public function query_skill_mapped($skill)
    {
        if (isset($this->skills_enable[$skill]))
		    return $this->skills_enable[$skill];
	    else
            return false;
    }

    public function query_skill_eff_lvl($skill)
    {
        if ($lv = $this->query_skill($skill)) {
            global $GAMESKILLS;
            $this_skill = $GAMESKILLS->get($skill);
            if (method_exists($this_skill, 'effective_level'))
                $eff_lv = $this_skill->effective_level();
            else
                $eff_lv = 5;
            return $lv * $eff_lv / 10;
        }
        else
            return 0;
    }

    public function improve_skill($skill_id, $amount)
    {
        global $GAMESKILLS;
        if (!$skill = $GAMESKILLS->get($skill_id))
            return false;
        
        if (!$this->is_player())
            return false;

        $spi = $this->query('spi');
        $skills = $this->query_skills();

        if (count($skills) > $spi)
		    $amount /= count($skills) - $spi;

	    if ($amount <= 1)
            $amount = 1;

	    $this->add_learnpoint($skill_id, intval($amount));

    	if ($this->get_learnpoint($skill_id) > ($this->skills[$skill_id] + 1) * ($this->skills[$skill_id] + 1)) {
            $this->set_skill($skill_id, $this->skills[$skill_id] + 1);
            
            $this->set_learnpoint($skill_id, 0);
            $this->get_conn()->ssend('HIC你的「' . $skill->get_name() . '」进步了！NOR');
            if (method_exists($skill, 'skill_improved'))
                $skill->skill_improved($this);
        }
    }

    public function visible($target)
    {
        if ($target->query_temp('visible') != null)
            return false;
        else
            return true;
    }

    public function query_attr($key)
    {
        if (isset($this->$key))
            $var = $this->$key;
        else 
            $var = 0;
        if (isset($this->temp['apply/' . $key]))
            $var += $this->temp['apply/' . $key];
        return $var;
    }

    public function is_busy()
    {
        if (null !== $this->query_temp('busy') && ($this->query_temp('busy') > time())) {
            return true;
        }
        else
            return false;
    }

    public function start_busy($s)
    {
        if (null == $this->query_temp('busy') || $this->query_temp('busy') <= time())
            $this->set_temp('busy', time() + $s);
        else {
            $this->set_temp('busy', intval($this->query_temp('busy') + $s));
        }
        return true;
    }

    public function remove_busy()
    {
        $this->del_temp('busy');
        return true;
    }

    public function is_fighting($target = null)
    {
        if ($target == null) {
            if (null != $this->query_temp('in_fighting'))
                return true;
            else
                return false;
        }
        else {
            $enemy = $this->query_temp('enemy');
            if (isset($enemy)) {
                foreach ($enemy as $v) {
                    if ($v == $target)
                        return true;
                }
            }
            return false;
        }
    }

    public function remove_all_enemy()
    {
        $enemy = $this->query_temp('enemy');
        if (null == $enemy)
            return false;
        foreach ($enemy as $k => $v) {
            $v->remove_enemy($this);
            unset($enemy[$k]);
        }
        $this->set_temp('enemy', null);
        $this->set_temp('in_fighting', 0);
        return true;
    }

    public function query_enemy()
    {
        return $this->query_temp('enemy');
    }

    public function remove_enemy($target)
    {
        $enemy = $this->query_temp('enemy');
        if ($enemy == null) 
            return true;
        
        foreach ($enemy as $k => $v) {
            if ($v == $target)
                unset($enemy[$k]);
        }
        $this->set_temp('enemy', $enemy);

        if (null == $enemy) {
            $this->set_temp('in_fighting', 0);
        }
        return true;
    }

    public function is_killing($id)
    {
        if (null == $this->query_temp('killer'))
           return false;

        if (isset($id)) {
            $killers = $this->query_temp('killer');
            if (array_key_exists($id, $killers))
                return true;
            else
                return false;
        }      
    }

    public function remove_killer($ob)
    {
        if ($this->is_killing($ob->query("id")) ) {
            $id = $ob->query("id");
		    $killers = $this->query_temp('killer');
            if (array_key_exists($id, $killers))
                unset($killers[$id]);
            $this->set_temp('killer', $killers);
        }
		$this->remove_enemy($ob);
		return true;
	}

    public function remove_all_killer()
    {
        $enemy = $this->query_temp('enemy');
        if (isset($enemy)) {
            foreach ($enemy as $k => $v) {
                $v->remove_killer($this);
            }
        }
        $this->set_temp('killer', null);
        $this->set_temp('enemy', null);
        $this->set_temp('in_fighting', 0);
    }


    public function is_player()
    {
        if (isset($this->is_player))
            return $this->is_player;
        else
            return false;
    }

    public function fight_ob($target)
    {
        if ($this == $target) {
            return false;
        }

        $this->set_temp('in_fighting', 1);

        if (null == $this->query_temp('enemy')) {
            $this->set_temp('enemy', array($target));
        }
        else {
            $flag = false;
            foreach ($this->query_temp('enemy') as $k => $v) {
                $v == $target;
                $flag = true;
                break;
            }
            if ($flag)
                return false;
            else
                array_push($this->temp['enemy'], $target);
        }
    }

    public function kill_ob($target)
    {
        if (null == $this->query_temp('killer'))
           $this->set_temp('killer', array($target->id => $target));

	    if ($target->is_player())
            $target->get_conn()->ssend("HIR看起来" . $this->query('name') . "想杀死你！NOR");

	    $this->fight_ob($target);
    }

    public function reset_action()
    {
        if(null != $this->query_temp("weapon")) {
            $weapon = $this->query_temp("weapon");
            $type = $weapon->query("skill_type");
        }
        elseif (null != $this->query_temp("secondary_weapon")) {
            $weapon = $this->query_temp("secondary_weapon");
            $type = $weapon->query("skill_type");
        }
        else
            $type = "unarmed";

        if ($enable_skill_name = $this->query_skill_mapped($type)) {
            /*  使用特殊技能的actions */
            global $GAMESKILLS;
            $enable_skill = $GAMESKILLS->get($enable_skill_name);
            if ($enable_skill->actions != null)
                $this->set('actions', $enable_skill->actions);
            else 
                $this->set('actions', $this->query('default_actions'));
        } else {
            /* 使用武器的actions */ 
            if (isset($weapon) && $weapon->query('actions') != null) {
                $this->set('actions', $weapon->query('actions'));
            }
            else 
                $this->set('actions', $this->query('default_actions'));
        }
    }

    public function receive_damage($type, $damage, $target = null)
    {
        if ($damage < 0) 
            echo "F_DAMAGE: 伤害值为负值。\n";
	    if ($type !='gin' && $type != 'kee' && $type !='sen')
		    echo "F_DAMAGE: 伤害种类错误(只能是 gin, kee, sen 其中之一)。\n";

	    if (isset($target))
            $this->set_temp("last_damage_from", $target);
	    $val = intval($this->query($type) - $damage);
        $this->set($type, $val);
	    $this->set_heart_beat(1);
	    return $damage;
    }

    public function receive_wound($type, $damage, $target = null)
    {
        if ($damage < 0) 
            echo "F_DAMAGE: 伤害值为负值。\n";
	    if ($type !='gin' && $type != 'kee' && $type !='sen')
		    echo "F_DAMAGE: 伤害种类错误(只能是 gin, kee, sen 其中之一)。\n";

	    if (isset($target))
            $this->set_temp("last_damage_from", $target);
	    $val = intval($this->query('eff_' . $type) - $damage);
        $this->set('eff_' . $type, $val);
        if ($this->query($type) > $val) 
            $this->set($type, $val);
	    $this->set_heart_beat(1);
	    return $damage;
    }

    public function receive_curing($type, $heal)
    {
        if ($heal < 0)
            return false;
        if ($type != 'gin' && $type != 'kee' && $type != 'sen')
            return false;
        $val = $this->query("eff_" . $type);
	    $max = $this->query("max_" . $type);

	    if ($val + $heal > $max) {
		    $this->set("eff_" . $type, $max);
		    return $max - $val;
	    } else {
		    $this->set("eff_" . $type, $val + $heal);
		return $heal;
        }
    }

    public function win_enemy($loser)
    {
        return true;
    }

    public function lose_enemy($winner)
    {
        return true;
    }

    public function dismiss_team()
    {
        return true;
    }

    public function die()
    {
        $killer = null;
        $this->clear_conditions();
        global $COMBAT_D, $CHAR_D, $OBJECT;
        $COMBAT_D->announce($this, "dead");
        
        if (null != $this->query_temp("last_damage_from")) {
            $killer = $this->query_temp("last_damage_from");
		    $this->set_temp("my_killer", $killer->query("id"));
		    $this->set_temp("my_killer_name", $killer->query("name"));
		    $COMBAT_D->killer_reward($killer, $this);
	    }
        
        $corpse = $CHAR_D->make_corpse($this, $killer);

        $this->remove_all_killer();
	    $this->dismiss_team();

        if ($this->is_player()) {
            $COMBAT_D->victim_penalty($this, $killer);
            $this->add('killed', 1);
		    $this->set("gin", 1);
            $this->set("eff_gin", 1);
		    $this->set("kee", 1);
            $this->set("eff_kee", 1);
		    $this->set("sen", 1);
            $this->set("eff_sen", 1);
            $this->set('force_factor', 0);
            $this->set('force', 0);
		    $this->is_ghost = true;
		    
		    if (null != $this->query_temp("no_death_penalty"))
            {
                $room = $OBJECT->get_room(DEATH_ROOM_NO_PEN);
                $this->move($room);
                $this->set_temp("no_death_penalty", null);
            }
		    else {	    
                $room = $OBJECT->get_room(DEATH_ROOM);
                $this->move($room);
            }          
            $this->set('startroom', DEATH_ROOM);
            $this->save();
	    } 
        else
		    $this->destruct();
    }

    public function clear_conditions()
    {
        $this->conditions = array();
    }

    public function apply_condition($condition)
    {
        $this->conditions[] = $condition;
    }

    public function get_conditions()
    {
        return $this->conditions;
    }

    public function killed_enemy()
    {
        return true;
    }

    public function query_team()
    {
        return array();
    }

    public function unconcious()
    {
        global $COMBAT_D;
        if (!$this->living()) {
            return false;
        }
	    if ($this->wizardp() && $this->query('immortal') != null) {
            return false;
        }

	    if (null != $this->query_temp("is_unconcious")) {
            return false;
        }
	    $this->set_temp("is_unconcious",1);
	    /*if (null != $this->query_temp("last_damage_from")) {
            $defeater = $this->query_temp("last_damage_from");
            $COMBAT_D->winner_reward($defeater, $this);
		    $COMBAT_D->loser_penalty($defeater, $this);
        }*/

        if (null == $this->query("possessed"))
	        $this->remove_all_enemy();

        if ($this->is_player())
	        $this->get_conn()->ssend('HIR你的眼前一黑，接著什麽也不知道了....NOR');
    	$this->disable_player(" <昏迷不醒>");
        $this->set("gin", 0);
        $this->set("kee", 0);
        $this->set("sen", 0);
	    $this->set_temp("block_msg/all", 1);
	    $COMBAT_D->announce($this, "unconcious");
        $s = 50 - $this->query('con') + 10;
        if ($s < 1)
            $s = 1;
        Timer::add($s, array($this, 'revive'), array(), false);
    }

    private function disable_player($type)
    {
        $this->set('disable_type', $type);
        $this->set_temp('disable_inputs', 1);
    }

    private function enable_player()
    {
        $this->set('disable_type', null);
        $this->set_temp('disable_inputs', null);
    }

    public function revive()
    {
        if ($this->is_player())
            $this->get_conn()->ssend('慢慢地你终於又有了知觉....');
        $this->set_temp("is_unconcious", null);
	
        if ($this->query("gin") < 0)
            $this->set("gin", 0);
        if ($this->query("kee") < 0) 
            $this->set("kee", 0);
        if ($this->query("sen") < 0)
            $this->set("sen", 0);
        global $COMBAT_D;
		$COMBAT_D->announce($this, "revive");
		$this->set_temp("block_msg/all", null);
        $this->enable_player();
    }

    
    public function carry_object($key)
    {
        global $OBJECT;
        $obj = $OBJECT->create_objects($key);
        $obj->move($this);
        return $obj;
    }

    public function add_money($type, $amount)
    {
        $obj = $this->carry_object("/obj/money/" . $type);
	    if (!isset($obj)) 
            return false;
        else
            $obj->set_amount($amount);
    }

    public function chating()
    {   
        $i = rand(0, NPC_CHAT_RATIO);
        if ($i < $this->query('chat_chance')) {
            $msgs = $this->query('chat_msg');

            $msg = $msgs[rand(0, count($msgs) - 1)];

            if (substr($msg, 0, 1) == ':') {
                $act = substr($msg, 1);
                if (method_exists($this, $act))
                    $this->$act();
            } else {
                msg::message_text('vision', $msg, $this);
            }
            return true;
        }  
    }

    public function auto_combat_perform()
    {
        if ($this->is_busy())
            return false;
        if (rand(0, NPC_C0MBAT_CHAT) < $this->query('chat_chance_combat') && $this->is_fighting()) {
            $combat_actions = $this->query('chat_msg_combat');
            $combat_action = $combat_actions[rand(0, count($combat_actions) - 1)];
            if ($combat_action == null || $combat_action == '')
                return false;
            global $DEFAULT_CONN;
            $DEFAULT_CONN->init($this);
            $this->do_cmd($DEFAULT_CONN, $combat_action);
            return true;
        }
        return false;
    }

    public function query_all_alias()
    {
        return $this->alias;
    }

    public function set_alias($s_cmd, $full_cmd)
    {
        $this->alias[$s_cmd] = $full_cmd;
        return $full_cmd;
    }

    public function del_alias($s_cmd)
    {
        if (isset($this->alias[$s_cmd])) {
            unset($this->alias[$s_cmd]);
        }
        return true;
    }

    private function convertalias($command)
    {
        $alias = $this->query_all_alias();
        if (isset($alias[$command]))
            return $alias[$command];
        else
            return $command;
    }

    public function skill_death_penalty()
    {
        $skills = $this->query_skills();
        $lv = 0;
        $this_skill = null;
        foreach ($skills as $k => $v) {
            if ($v > $lv) {
                $lv = $v;
                $this_skill = $k;
            }
        }
        $this->set_skill($this_skill, intval($lv - 1));
        return true;
    }

    public function random_move()
    {
        $env = $this->get_env();
        $exits = $env->query('exits');
        if (null == $exits || count($exits) < 1) {
            return false;
        }

        $keys = array_rand($exits, 1);
        global $DEFAULT_CONN;
        $DEFAULT_CONN->init($this);
        $this->do_cmd($DEFAULT_CONN, 'go '. $keys);
    }

    public function set_mark($key, $value)
    {
        $this->marks[$key] = $value;
    }

    public function get_mark($key)
    {
        if (isset($this->marks[$key]))
            return $this->marks[$key];
        else
            return false;
    }

    public function del_mark($key)
    {
        if (isset($this->marks[$key]))
            unset($this->marks[$key]);
        return true;
    }

    public function query_leader()
    {
        if ($this->query('leader') != null)
            return $this->query('leader');
        else
            return false;
    }

    public function set_leader($leader)
    {
        $this->set('leader', $leader);
    }

    public function del_leader()
    {
        if ($this->query('leader') != null)
            $this->del('leader');
    }

    public function follow_me($leader, $dir)
    {
        if (($this->query_leader() == $leader) && ($this != $leader) && $this->living()) {
            $this->remove_all_enemy();
            if ($this->is_player()) {
                $this->do_cmd($this->get_conn(), 'go '. $dir);
            }
            else {
                global $DEFAULT_CONN;
                $DEFAULT_CONN->init($this);
                $this->do_cmd($DEFAULT_CONN, 'go '. $dir);
            }
        }
    }
}
