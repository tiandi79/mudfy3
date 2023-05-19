<?php 
/**
*  查看
*
*/
namespace cmds\std;

use libs\msg;

class look
{
    private $look_level = array("BLU不堪一击NOR", "BLU毫不足虑NOR", "BLU不足挂齿NOR", "BLU初学乍练NOR", "HIB初窥门径NOR", "HIB略知一二NOR", "HIB普普通通NOR", "HIB平平淡淡NOR", "HIB平淡无奇NOR", "HIB粗通皮毛NOR", "HIB半生不熟NOR", "HIB马马虎虎NOR", "HIB略有小成NOR", "HIB已有小成NOR", "HIB驾轻就熟NOR", "CYN心领神会NOR", "CYN了然於胸NOR", "CYN略有大成NOR", "CYN已有大成NOR", "CYN豁然贯通NOR", "CYN出类拔萃NOR", "CYN无可匹敌NOR", "CYN技冠群雄NOR", "CYN神乎其技NOR", "CYN出神入化NOR" ,"CYN傲视群雄NOR", "HIC登峰造极NOR", "HIC所向披靡NOR", "HIC一代宗师NOR", "HIC神功盖世NOR", "HIC举世无双NOR", "HIC惊世骇俗NOR", "HIC震古铄今NOR", "HIC深藏不露NOR", "HIR深不可测NOR");
    private $heavy_level_desc = array("极轻", "很轻", "不重", "不轻", "很重", "极重");
    function __construct()
    {

    }

    public function do_cmd($ob, $target = null)
    {
        global $OBJECT;
        $me = $ob->body;
        $place = $me->place;
        $room = $OBJECT->get_room($place->id);

        /* 如果没有参数，则是当前房间 */
        if (!isset($target)) {
            $this->look_room($ob, $room);
        }
        else {
            $objs1 = null;
            $objs2 = null;
            
            /* 当前地点存在的物件 */
            if (null !== ($room->all_inventory())) {
                $objs1 = $room->all_inventory();
            }

            /* 身上的物件 */
            if (null !== ($me->all_inventory())) {
                $objs2 = $me->all_inventory();
            }

            $objs = array_merge($objs1, $objs2);
            unset($objs1);
            unset($objs2);

            foreach ($objs as $k => $v) {
                if ($v->query('id') == $target) {
                    if ($v->is_character()) {
                        $this->look_living($ob, $v);
                        return true;
                    }
                    else {
                        $this->look_item($ob, $v);
                        return true;
                    }
                }                    
            }
            $ob->ssend('你要看什麽？');
            return false;
        }
    }

    public function look_living($ob, $target)
    {
        if ($target->is_player() && $target !== $ob->body) 
            $target->get_conn()->ssend($ob->body->query('name') . '正盯著你看，不知道打些什麽主意。');   
        
        if (null !== $target->query('long'))
            $ob->ssend($target->query('long'));
        
        global $CHINESE_D;
        if ($target->query('race') == '人类' && $target->query('age') != null) {
            if ($target->is_player())
                $ob->ssend($this->pro($target, $ob->body) . '看起来象' . $CHINESE_D->chinese_number(intval($target->query('age') /10) * 10) . '多岁的' . $target->query('national') . '人。' . $this->pro($target, $ob->body) . $this->getper($ob->body, $target));
            else
                $ob->ssend($this->pro($target, $ob->body) . '看起来约' . $CHINESE_D->chinese_number(intval($target->query('age') /10) * 10) . '多岁。' . $this->pro($target, $ob->body) . $this->getper($ob->body, $target));
        }
        
        $ob->ssend('武功看起来好象' . $this->getlev($target) . '，出手似乎' . $this->getdam($target) . '。');
        global $COMBAT_D;
        if ($target->query("max_kee"))
            $ob->ssend($this->pro($target, $ob->body) . $COMBAT_D->eff_status_msg($target->query("eff_kee") * 100 / $target->query("max_kee")));

        if (null != $target->query_temp('weapon')) {
            $weapon = $target->query_temp('weapon');
        }

        if (null != $target->query_temp('armor/cloth')) {
            $cloth = $target->query_temp('armor/cloth');
        }

        if (null != $target->query_temp('armor/boots')) {
            $boots = $target->query_temp('armor/boots');
        }

        if (null != $target->query_temp('armor/hat')) {
            $hat = $target->query_temp('armor/hat');
        }

        if (null != $target->query_temp('armor/ring')) {
            $ring = $target->query_temp('armor/ring');
        }
        
        if (isset($weapon) || isset($cloth) || isset($boots) || isset($hat) || isset($ring)) {
			$ob->ssend($this->pro($target, $ob->body) . "身上穿著：");
            if (isset($weapon))
                $ob->ssend("  √" . $weapon->query('name') . '(' . $weapon->query('id') . ')');
            if (isset($hat))
                $ob->ssend("  √" . $hat->query('name') . '(' . $hat->query('id') . ')');
            if (isset($cloth))
                $ob->ssend("  √" . $cloth->query('name') . '(' . $cloth->query('id') . ')');
            if (isset($ring))
                $ob->ssend("  √" . $ring->query('name') . '(' . $ring->query('id') . ')');
            if (isset($boots))
                $ob->ssend("  √" . $boots->query('name') . '(' . $boots->query('id') . ')');
        }			
    }

    private function getdam($target)
    {
        $level = 0;
        if ($target->query_temp("apply/damage"))
            $level = intval($target->query_temp("apply/damage"));
	    $level = $level / 50;
        if($level >= count($this->heavy_level_desc))
            $level = count($this->heavy_level_desc) - 1;
        return $this->heavy_level_desc[$level];
    }

    private function getlev($target)
    {
        if (null != $target->query_temp('weapon')) {
            $weapon = $target->query_temp('weapon');
            $skill_type = $weapon->skill_type;
        }
        else {
            $skill_type = "unarmed";
        }
        global $COMBAT_D;
        $attack_points = $COMBAT_D->skill_power($target, $skill_type, 'SKILL_USAGE_ATTACK');
        return $this->tough_level($attack_points);
    }

    private function tough_level($attack_points)
    {
    	if($attack_points < 0) 
            $attack_points = 0;
	    $rawlvl = pow($attack_points, 0.3);
	    $lvl = intval($rawlvl);
        $tough_level_desc = array();
        if($lvl >= count($this->look_level))
            $lvl = count($this->look_level) - 1;
        return $this->look_level[$lvl];
    }

    private function getper($user, $target)
    {
        $spi = $user->query_attr('spi');
        $per = $target->query_attr('per');

        /* 灵性差，看人不准 */
        if ($spi > 35) 
            $weight = 0;
	    else 
            $weight = intval(35 - $spi) / 4;

        if (rand(0,10) > 6)
            $per = $per - $weight;
        else
            $per = $per + $weight;
        
        $str = '';
        if ($target->query("gender") == "男性") {
		    if ($per > 20) 
                $str = "相貌出众，百里挑一。";
		    elseif (($per >= 15) && ($per <=30)) 
			    $str = "英俊潇洒，貌似潘安。";
		    elseif (($per >= 10) && ($per < 25)) 
			    $str = "五官端正。";
		    if ($per < 5) 
			    $str = "相貌平平。";
        }
        elseif ($target->query("gender") == "女性") {
            if ($per > 25)
                $str = "美奂绝伦，堪称人间仙子！";
            elseif (($per >= 20) && ($per <= 30)) 
                $str = "有沉鱼落雁之容，避月羞花之貌！";
            elseif (($per >= 15) && ($per < 25)) 
                $str = "风情万种，楚楚动人！"; 
            elseif (($per >= 10) && ($per < 20))
                $str = "相貌平平，还看得过去。";
            elseif ($per < 5) 
                $str = "的相貌嘛...马马虎虎吧。";
        }
        return $str; 
    }

    private function pro($target, $user)
    {
        if ($target === $user) {
            if ($target->query('gender') == '女性')
                return '妳';
            else
                return '你';
        }
        else {
            if ($target->query('race') != '人类')
                return '它';
            elseif ($target->query('gender') == '女性')
                return '她';
            else
                return '他';
        }
    }

    public function look_item($ob, $target)
    {
        $ob->ssend($target->query('long'));
	    $invs = $target->all_inventory();
	    if (!$target->is_close() && count($invs) > 0) {
            switch( $target->query("prep") ) {
                case "on":
                    $prep = "上";
                    break;
                case "under":
                    $prep = "下";
                    break;
                case "behind":
                    $prep = "后";
                    break;
                case "inside":
                    $prep = "里";
                    break;
                default:
                    $prep = "里";
                    break;
            }
		    $msg = $prep . "面有：";
            foreach ($invs as $v) {
                if ($v->query('short') != null)
                    $msg .= "<br>" . $v->query('short');
                else
                    $msg .= "<br>" . $v->query('name') . '('. $v->query('id') . ')';
            }
            $ob->ssend($msg);
        }
    }

    public function look_room($ob, $room)
    {
        if (!isset($ob->body->place)) {
            $ob->ssend("你的四周灰蒙蒙地一片，什麽也没有。");
            return false;
        }
        
        if ($ob->body->wizardp())
            $ob->ssend('-- ' . $room->name . ' ('. $room->id . ')[' . $room->query('coor/x') . ',' . $room->query('coor/y') . ',' . $room->query('coor/z') . ']');
        else
            $ob->ssend('-- ' . $room->name);
        $ob->ssend($room->long);
        
        if (null !== ($room->query('exits'))) {
            $exits = $room->query('exits');
            foreach ($exits as $k => $v) {
                if (null !== ($room->query_door($k)) && $room->query_door($k) == 1)
                    unset($exits[$k]);
            }
            $size = count($exits);
            if ($size == 0) {
                $ob->ssend("这里没有任何明显的出路。");
            }
            elseif ($size == 1) {
                $dirs = array_keys($exits);
                $ob->ssend('这里唯一的出口是 ' . $dirs[0] .'。');
            }
            else {
                $dirs = array_keys($exits);
                $tmp2 = end($dirs);
                array_pop($dirs);
                $tmp = implode("、", $dirs);
                $ob->ssend('这里明显的出口是 ' . $tmp . ' 和 ' . $tmp2);
            }
        }
        else {
            $ob->ssend("这里没有任何明显的出路。");
        }

        $objs = null;

        if (null !== ($room->all_inventory())) {
            $objs = $room->all_inventory();
        }

        foreach ($objs as $k => $v) {
            $status_msg = '';
            if (null != $v->query('disable_type'))
                $status_msg .= $v->query('disable_type');
            if (null !== $v->query('posts_count'))
                $status_msg .= ' [ ' . $v->query('posts_count') . ' 张留言 ]';
            if ($v->is_player()) { 
                $player_conn = $v->get_conn();
                if (isset($this_player->lasttime) && ((time() - $player_conn->lasttime) > IDLE_TIME))
                     $status_msg .= ' <发呆中>';
            }

            global $RANK_D;
            $rank_msg = $RANK_D->query_rank($v);
            if ($ob->body !== $v) {
                if ($v->is_ghost() && !$ob->body->wizardp()) 
                    continue;
                if ($v->query('short') != null)
                    $ob->ssend($v->query('short'));
                else {
                    if ($v->query('nickname') != null)
                        $nickname = '「' . $v->query('nickname') . '」';
                    else
                        $nickname = '';
                    $ob->ssend($rank_msg . ' ' . $v->query('title') . $nickname . ' ' . $v->query('name') . ' (' . $v->query('id') . ')' . $status_msg);
                }
            }
        }
    }

    public function help() 
    {
        $ret = "指令格式: look [<物品>|<生物>] 这个指令让你查看你所在的环境、某件物品、生物。";
        return $ret;
    }
}
