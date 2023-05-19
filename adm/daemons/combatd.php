<?php
/**
*  战斗核心
*
*/
namespace adm\daemons;

use \std\msg;

class combatd
{
    public $guard_msg = array();
    public $winner_msg = array();
    public $catch_hunt_msg = array();

    function __construct()
    {
        $this->guard_msg = array('CYN$N注视著$n的行动，企图寻找机会一击成功。NOR', 
        'CYN$N正盯著$n的一举一动，随时准备发动攻势。NOR', 
        'CYN$N以守为攻，想要找出$n的破绽。NOR', 
        'CYN$N缓缓地移动着脚步，等待着最佳的出招方位。NOR', 
        'CYN$N眼睛眨也不眨地盯着$n，伺机出手。NOR');

        $this->winner_msg = array('CYN$N哈哈大笑，说道：承让了！NOR',
        'CYN$N双手一拱，笑著说道：承让！NOR',
        'CYN$N胜了这招，向後跃开三尺，笑道：承让！NOR',
        'CYN$n脸色微变，说道：佩服，佩服！NOR',
        'CYN$n向後退了几步，说道：这场比试算我输了，佩服，佩服！NOR',
        'CYN$n向後一纵，躬身做揖说道：阁下武艺不凡，果然高明！NOR');

        $this->catch_hunt_msg = array('HIW$N和$n仇人相见分外眼红，立刻打了起来！NOR',
            'HIW$N对著$n大喝：「可恶，又是你！」NOR',
            'HIW$N和$n一碰面，二话不说就打了起来！NOR',
            'HIW$N一见到$n，愣了一愣，大叫：「我宰了你！」NOR',
            'HIW$N喝道：「$n，我们的帐还没算完，看招！」NOR');
    }

    public function damage_msg($damage, $type)
    {
        if ($damage == 0)
            return '结果没有造成任何伤害。';

        switch($type) {
            case "拉伤":
            case '割伤':
                if ($damage < 10) 
                    return '结果只是轻轻地划破$n的皮肉。';
                elseif ($damage < 20) 
                    return '结果在$n$l划出一道细长的血痕。';
                elseif ($damage < 40) 
                    return '结果「嗤」地一声划出一道伤口！';
                elseif ($damage < 80)
                    return '结果「嗤」地一声划出一道血淋淋的伤口！';
                elseif($damage < 160)
                    return '结果「嗤」地一声划出一道又长又深的伤口，溅得$N满脸鲜血！';
                else
                    return '结果只听见$n一声惨嚎，$w已在$n$l划出一道深及见骨的可怕伤口！！';
                break;
            case '刺伤':
                if ($damage < 10) 
                    return '结果只是轻轻地刺破$n的皮肉。';
                elseif ($damage < 20) 
                    return '结果在$n$l刺出一个创口。';
                elseif ($damage < 40) 
                    return '结果「噗」地一声刺入了$n$l寸许！';
                elseif ($damage < 80)
                    return '结果「噗」地一声刺进$n的$l，使$n不由自主地退了几步！';
                elseif($damage < 160)
                    return '结果「噗嗤」地一声，$w已在$n$l刺出一个血肉模糊的血窟窿！';
                else
                    return '结果只听见$n一声惨嚎，$w已在$n的$l对穿而出，鲜血溅得满地！！';
                break;
            case '瘀伤':
                if ($damage < 10) 
                    return '结果只是轻轻地碰到，比拍苍蝇稍微重了点。';
                elseif ($damage < 20) 
                    return '结果在$n的$l造成一处瘀青。';
                elseif ($damage < 40) 
                    return '结果一击命中，$n的$l登时肿了一块老高！';
                elseif ($damage < 80)
                    return '结果一击命中，$n闷哼了一声显然吃了不小的亏！';
                elseif ($damage < 120)
                    return '结果「砰」地一声，$n退了两步！';
                elseif($damage < 160)
                    return '结果这一下「砰」地一声打得$n连退了好几步，差一点摔倒！';
                elseif($damage < 240)
                    return '结果重重地击中，$n「哇」地一声吐出一口鲜血！';
                else
                    return '结果只听见「砰」地一声巨响，$n像一捆稻草般飞了出去！！';
                break;
            case '抓伤':
                if ($damage < 10) 
                    return '结果只是轻轻地抓到，比抓痒稍微重了点。';
                elseif ($damage < 20) 
                    return '结果在$n的$l抓出几条血痕。';
                elseif ($damage < 40) 
                    return '结果一抓命中，$n的$l被抓得鲜血飞溅！';
                elseif ($damage < 80)
                    return '结果「嗤」地一声，$l被抓得深可见骨！';
                elseif ($damage < 120)
                    return '结果一抓命中，$n的$l被抓得血肉横飞！';
                elseif($damage < 160)
                    return '结果这一下「嗤」地一声抓得$n连晃好几下，差一点摔倒！';
                elseif($damage < 240)
                    return '结果$n哀号一声，$l被抓得筋断骨折！！';
                else
                    return '结果只听见$n一声惨嚎，$l被抓出五个血窟窿！鲜血溅得满地！！';
                break;
            case '反弹伤':
                if ($damage < 5) 
                    return '$N受到$n$z的反震，闷哼一声。';
                elseif ($damage < 10) 
                    return  '$N被$n的$z震得气血翻腾，大惊失色。';
                elseif ($damage < 20) 
                    return '$N被$n的$z震得站立不稳，摇摇晃晃。';
                elseif ($damage < 40) 
                    return '$N被$n以$z反震，「嘿」地一声退了两步。';
                elseif ($damage < 80) 
                    return '$N被$n的$z反弹回来的力量震得半身发麻。';
                elseif ($damage < 120) 
                    return '$N被$n的$z反弹力一震，胸口有如受到一记重击，连退了五六步！';
                elseif ($damage < 160) 
                    return '$N被$n的$z一震，眼前一黑，身子向後飞出丈许！！';
                else 
                    return '$N被$n的$z一震，眼前一黑，狂吐鲜血，身子象断了线的风筝向後飞去！！';
                break;
            default:
                if (null == $type)
                    $type = '伤害';
                if ($damage < 10) 
                    $msg = '结果只是勉强造成一处轻微';
                elseif ($damage < 20) 
                    $msg = '结果造成轻微的';
                elseif ($damage < 30) 
                    $msg = '结果造成一处';
                elseif ($damage < 50)
                    $msg = '结果造成一处严重';
                elseif ($damage < 80)
                    $msg = '结果造成颇为严重的';
                elseif($damage < 120)
                    $msg = '结果造成相当严重的';
                elseif($damage < 170)
                    $msg = '结果造成十分严重的';
                elseif($damage < 230)
                    $msg = '结果造成极其严重的';
                else
                    $msg = '结果造成非常可怕的严重';
                return $msg . $type . '!';
        }
    }

    public function eff_status_msg($ratio)
    {
        if ($ratio == 100) 
            return 'HIG精神饱满，正处于巅峰状态。NOR';
        if ($ratio > 95) 
            return 'HIG似乎只受了点轻伤，但无伤大体。NOR';
        if ($ratio > 90) 
            return 'HIY看起来可能受了几处皮肉伤。NOR';
        if ($ratio > 80)
            return 'HIY受了几处创伤，不过似乎并不碍事。NOR';
        if ($ratio > 60) 
            return 'HIY受伤不轻，正在流着血。NOR';
        if ($ratio > 40) 
            return 'HIR气息粗重，动作散乱，已经在走下坡路了。NOR';
        if ($ratio > 30) 
            return 'HIR已经眼神散乱，正在勉力支撑著不倒下去。NOR';
        if ($ratio > 20) 
            return 'HIR遍体鳞伤，只剩下最后一口气了。NOR';
        if ($ratio > 10)
            return 'RED伤重之下已经难以支撑，眼看就要倒在地上。NOR';
        if ($ratio > 5) 
            return 'RED瞳空放大，已经奄奄一息，命在旦夕了。NOR';
        else
            return 'RED满身鲜血，已经有如风中残烛，随时都可能断气。NOR';
    }

    public function status_msg($ratio)
    {
        if ($ratio == 100) 
            return 'HIG看起来精神饱满，正处于巅峰状态。NOR';
        if ($ratio > 95) 
            return 'HIG似乎有些疲惫，但是仍然十分有活力。NOR';
        if ($ratio > 90) 
            return 'HIY看起来可能有些不济。NOR';
        if ($ratio > 80)
            return 'HIY动作似乎开始有点不太灵光，但是仍然有条不紊。NOR';
        if ($ratio > 60) 
            return 'HIY气喘嘘嘘，脸色惨白。NOR';
        if ($ratio > 40) 
            return 'HIR似乎十分疲惫，看来需要好好休息了。NOR';
        if ($ratio > 30) 
            return 'HIR已经一副头重脚轻的模样，正在勉力支撑著不倒下去。NOR';
        if ($ratio > 20) 
            return 'HIR看起来已经力不从心了。NOR';
        if ($ratio > 10)
            return 'RED摇头晃脑、歪歪斜斜地站都站不稳，眼看就要倒在地上。NOR';
        else
            return 'RED已经陷入半昏迷状态，随时都可能摔倒晕去。NOR';
    }

    public function skill_power($char, $skill, $usage)
    {
        if (null == $char->living()) {
            return 0;
        }
        if (null != $char->query_temp('is_unconcious'))
            return 0;
        $max = intval($char->query_max_encumbrance());
        $enc = ($max  + $max / 10 - 1 - intval($char->query_encumbrance())) * 10 / $max;
        if (!isset($char->is_player))
            $enc = 10;

        $level = $char->query_skill($skill);
        switch ($usage) {
            case 1:
                $level += $char->query_temp('apply/attack');
                break;
            case 2:
                $level += $char->query_temp('apply/defense');
                break;
            case 3:
                $level += $char->query_temp('apply/move');
        }
        
        if (!$level) {
            return intval($char->combat_exp / 50 * $enc / 10);
        }

        if (isset($char->max_sen) && $char->max_sen > 0)
            $nower = ($level * ($level / 10) * ($level /  10)) / 5 * $char->sen / $char->max_sen;
        else
            $nower = ($level * ($level / 10) * ($level / 10)) / 5;

        if ($usage == 3)
            return intval($nower * $enc / 10);
        else
            return intval(($nower + $char->combat_exp / 25) * $enc / 10);
    }

    public function fight($me, $victim)
    {
        if (!$me->living())
            return false;

        if ($me->is_busy())
            return false;

        /* 战斗消耗*/
        if ($me->is_player())
            $me->sen--;

        if (!$me->visible($victim) && (rand(0, $me->query_skill("perception") + 110) < 100))
            return false;
        /* 对手忙或者无法活动，保证自己出手 */
        if ($victim->is_busy() || !$victim->living()) {
            $me->set_temp("guarding", 0);
            if (!$victim->is_fighting($me))
                $victim->fight_ob($me);
                $this->do_attack($me, $victim, $me->query_temp("weapon"), TYPE_QUICK);
        }
        /* 判断是否有勇气出手 */
        else { 
            $myagi = $me->query_attr('agi');
            $youragi = rand(0, $victim->query_attr('agi'));
            $myexp = rand(0, $me->query('combat_exp'));
            $yourexp = rand(0, $victim->query('combat_exp'));
            //echo "\n".$me->name.":myagi=". $myagi. " youragi=".$youragi. " myexp=". $myexp. " yourexp=". $yourexp;
            if ($myagi > $youragi || $myexp > $yourexp) {
                if ($me->query_attr('cor') > rand(0, $victim->query_attr('cps'))) {
                    $me->set_temp("guarding", 0);
                    if (!$victim->is_fighting($me))
                    $victim->fight_ob($me);
                    //echo "\n".$me->name." do attack";
                    $this->do_attack($me, $victim, $me->query_temp("weapon"), TYPE_REGULAR);
                } else {
                    if(!$me->query_temp("guarding")) {
                        $me->set_temp("guarding", 1);
                       //echo "\n".$me->name." do guard";
                        msg::message('vision',$this->guard_msg[rand(0, count($this->guard_msg) -1)], $me, $victim);
                    }
                }
            } else {
               // echo "\n".$me->name." do nothing";
            }
        }
    }

    public function do_attack($me, $victim, $weapon, $attack_type, $attack_msg = null, $damtype = null)
    {
        if ($me->query_temp('is_unconcious'))
            return false;
        
        /* 1.选择action */
        //if (null == $me->query('actions'))
            $me->reset_action();

        $actions = $me->query('actions');
        if (!isset($actions[0])) {
            /* 根据武器返回actions，已经随机处理过了，只有一条 */
            $action = $actions;
        }
        else {
            /* 默认actions是个数组 */
            $action = $actions[rand(0, count($actions) - 1)];
        }
        $result = "<br>" . $action["action"] . "！";
        if ($attack_msg != null)
            $result = "<br>" . $attack_msg;

        if (isset($weapon))
            $attack_skill = $weapon->query("skill_type");
        else                                    
            $attack_skill = "unarmed";

        $limbs = $victim->query("limbs");
        $limb = $limbs[rand(0, count($limbs) - 1)];
        
        /* 2.计算ap, dp */
        global $COMBAT_D, $GAMESKILLS;
        $wounded = 0;
        $ap = $COMBAT_D->skill_power($me, $attack_skill, SKILL_USAGE_ATTACK);
        if($ap < 1) 
            $ap = 1;

        $dp = $COMBAT_D->skill_power($victim, "dodge", SKILL_USAGE_DEFENSE);
        if (isset($action["dodge"]))
		    $dp -= $dp * $action["dodge"] / 1000 ;
        if ($dp < 1 ) 
            $dp = 1;
        if ($victim->is_busy()) 
            $dp /= 3;

        if ($me->is_player())
        {
            if(null != $me->query("force_factor") && ($me->query('force') > $me->query('force_factor'))) 
			    $me->set('force', $me->query('force') - $me->query('force_factor'));
			else
				$me->set('force_factor', 0);
        }
        /* 对手有保护 */
        if (null != $victim->query_temp("protectors")) 
        {
            
        } else {
            /* 3.战斗 */
            /* 对手是否闪躲成功 */
            //echo $me->name."ap=".$ap."|dp=".$dp."\n";
            if (!TEST_NO_DODGE && rand(0, ($ap + $dp)) < $dp ) {       
                $dodge_skill = $victim->query_skill_mapped("dodge");
                if (!$dodge_skill ) 
                    $dodge_skill = "dodge";

                $result .= "<br>" . $GAMESKILLS->get($dodge_skill)->query_dodge_msg($limb);

                if ($dp < $ap && $victim->is_player() && rand(0, $victim->query('gin') * 100 / $victim->query('max_gin') + $victim->query('int')) > 50 ) {
                     $victim->set('potential', $victim->query('potential') + 1);
                     $victim->set('combat_exp', $victim->query('combat_exp') + 1);
                     $victim->improve_skill("dodge", 1);
                }
                $damage = RESULT_DODGE;
            } else {
                /* 闪躲不成功后，判断对手是否能招架 */
                if (null != $victim->query_temp("weapon")) {
                    $np = $COMBAT_D->skill_power($victim, "parry", SKILL_USAGE_DEFENSE);
                    if (!isset($weapon)) 
                        $np *= 2;
                } else {
                    if ($weapon) 
                        $np = $COMBAT_D->skill_power($victim, "unarmed", SKILL_USAGE_DEFENSE) / 2;
                    else 
                        $np = $COMBAT_D->skill_power($victim, "unarmed", SKILL_USAGE_DEFENSE);
                }

                if (isset($action["parry"]))
                    $np -= $np * $action["parry"] / 1000 ;
                if ($victim->is_busy()) 
                    $np /= 3;
                if ($np < 1) 
                    $np = 1;
                
                /* 对手招架成功 */
                if (TEST_PARRY || rand(0, $ap + $np) < $np) {
                    if (null != $victim->query_temp("weapon")) {
                        $parry_skill = $victim->query_skill_mapped("parry");
                        if (!$parry_skill)
                            $parry_skill = "parry";
                    } else {
                        $parry_skill = $victim->query_skill_mapped("unarmed");
                        if (!$parry_skill)
                            $parry_skill = "unarmed";	
                    }

                    $result .= "<br>" . $GAMESKILLS->get($parry_skill)->query_parry_msg($me->query_temp("weapon"));
                    if ($np < $ap && $victim->is_player() && rand(0, ($victim->query('gin') * 100 / $victim->query('max_gin') + $victim->query('int')) > 50)) {
                        $victim->set('potential', $victim->query('potential') + 1);
                        $victim->set('combat_exp', $victim->query('combat_exp') + 1);
                        $victim->improve_skill("parry", 1);
                    }
                    $damage = RESULT_PARRY;
                } else {
                    /* 对手招架失败，被打中 */
                    $damage = $me->query_temp("apply/damage") + 2;
                    $damage = ($damage + rand(0, $damage)) / 2;
                    if (isset($action["damage"]))
                        $damage += $action["damage"] * $damage / 1000;

                    $damage_bonus = $me->query('str');
			        $damage_bonus = $damage_bonus * $damage_bonus / 10;
                    
                    /* 使用武器，则消弱 */
			        if (isset($weapon))
                        $damage_bonus -= $damage_bonus / 3;

                    /* 内力加成 */
                    if (null != $me->query('force_factor') && ($me->query('force') > $me->query('force_factor'))) {
                        if (null != $me->query_skill_mapped("force")) {
                            $force_skill = $me->query_skill_mapped("force");
                            $force_skill = $GAMESKILLS->get($force_skill);
                            if (method_exists($force_skill, 'hit_ob')) {
                                $foo = $force_skill->hit_ob($me, $victim, $damage_bonus, $me->query('force_factor'));
                                if (is_numeric($foo))
                                    $damage_bonus += $foo;
                                else
                                    $result .= $foo;
                            }
                        }
                    }
                    if (isset($action["force"]))
                        $damage_bonus += $action["force"] * $damage_bonus / 1000;

                    if (null != $me->query_skill_mapped($attack_skill)) {
                        $martial_skill = $me->query_skill_mapped($attack_skill);
                        $martial_skill = $GAMESKILLS->get($martial_skill);
                        if (method_exists($martial_skill, 'hit_ob')) {
                            $foo = $martial_skill->hit_ob($me, $victim, $damage_bonus);
                            if (is_numeric($foo))
                                $damage_bonus += $foo;
                            else
                                $result .= "<br>" . $foo;
                        }
                    }

                    /* 武器额外伤害 */
                    if (isset($weapon)) {
                        if (method_exists($weapon, 'hit_ob')) {
                            $foo = $weapon->hit_ob($me, $victim, $damage_bonus);
                            if (is_numeric($foo))
                                $damage_bonus += $foo;
                            else
                                $result .= "<br>" . $foo;
                        }
                    } 
                    /* 妖兽额外伤害 */
                    if (method_exists($me, 'hit_ob')) {
                        $foo = $me->hit_ob($me, $victim, $damage_bonus);
                        if (is_numeric($foo))
                            $damage_bonus += $foo;
                        else
                            $result .= "<br>" . $foo;
                    }

                    if ($damage_bonus > 0)
                        $damage += ($damage_bonus + rand(0, $damage_bonus)) / 2;
                    if ($damage < 0 ) 
                        $damage = 0;

                    /* 经验影响伤害 */
                    $bounce = $victim->query('combat_exp');
                    while(rand(0, $bounce) > $me->query('combat_exp')) {
                        $damage -= $damage / 5;
                        $bounce /= 2;
                        }
				    $bounce = 0;

                    /* 韧性直接减免伤害 */
                    $damage -= rand(0, $victim->query_attr('fle'));
				    $damage -= rand(0, $victim->query_temp("apply/extra_fle"));
                    if ($damage < 0)
                        $damage = 0;

                    /*  对手是否能反震 */
                    $absorb_vic = $victim->query_skill("ironcloth") + $victim->query_temp("apply/ironcloth") * 2;	

				    if (null != $victim->query_skill("ironcloth")) {
                        $absorb_skill = $victim->query_skill_mapped("ironcloth");
                        if (!$absorb_skill) 
                            $absorb_skill = "ironcloth";
                        $result .= "<br>" . $GAMESKILLS->get($absorb_skill)->query_absorb_msg();
                    }
                    
                    $damage_bonus = $me->query_skill("ironcloth");
                    if (($damage - $absorb_vic) < 0)
                    {
                        /* 对手反震等级 */
                        $absorb_skill = $victim->query_skill_mapped("ironcloth");
                        if ($absorb_skill)
                            $bounce = 0 - ($GAMESKILLS->get($absorb_skill)->bounce_ratio() * ($damage - $absorb_vic) / 10);
                        else
                            $bounce = 0;
                        /* 按自身反震等级进行部分减免 */
                        $absorb_skill = $me->query_skill_mapped("ironcloth");
                        if ($absorb_skill)
                            $bounce -= ($GAMESKILLS->get($absorb_skill)->bounce_ratio()) * $damage_bonus / 10;

                        if ($bounce < 0)
                            $bounce = 0;
                            $me->receive_damage("kee", $bounce, $victim);
                            $result .= $this->damage_msg($bounce, "反弹伤");
                    }
                    else {
                        /* 打中对方 */
                        $damage = $victim->receive_damage("kee", $damage, $me);
                        if ($me->is_player() && $me->wizardp())
                            $me->get_conn()->ssend('<br>AP:'. $ap . ' DP:' . $dp . ' Damage:' . intval($damage) . ' Type:' . 'kee');
                        
                        if (($me->is_killing($victim->id) || null != $weapon) && rand(0, $damage) > $victim->query_temp("apply/armor")) {
                            /* 伤害比护具防御高 */
                            $victim->receive_wound("kee", $damage - $victim->query_temp("apply/armor"), $me);
                            $wounded = 1;
                        }
                        if (isset($damtype)) 
		                    $result .= "<br>" . $this->damage_msg($damage, $damtype);
		                else
                            $result .= "<br>" . $this->damage_msg($damage, $action["damage_type"]);
                    }
                    /* 计算战斗经验 */
                    if (CAN_ADD_EXP_ON_COMBAT) {
                        if ($me->is_player() && $me->query('combat_exp') < CAN_ADD_EXP_BEFORE_EXP) {
                            if (($ap < $dp) && (rand(0, $me->query('sen') * 100 / $me->query('max_sen')) > 50)) {
                                if (rand(0, 100) < CAN_ADD_EXP_RATE) {
                                    $me->set('potential', $me->query('potential') + 1);
                                    $me->set('combat_exp', $me->query('combat_exp') + 1);
                                }
                                $me->improve_skill($attack_skill, 1);
                            }
                        }
                    }                   
				}
            }
        }
        
        /* 输出显示 */
        $result = str_replace('$l', $limb, $result) . "<br>";
        if (null != $victim->query_temp("weapon"))
	        $result = str_replace('$v', $victim->query_temp("weapon")->name, $result);
	    if (null != $victim->query_skill_mapped("ironcloth"))
	        $result = str_replace('$z', $GAMESKILLS->get($victim->query_skill_mapped("ironcloth"))->name(), $result);

        if (isset($weapon))
            $result = str_replace('$w', $weapon->name, $result);
        elseif (isset($action["weapon"]))
            $result = str_replace('$w', $action["weapon"], $result);

        msg::message('vision', $result, $me, $victim);

        /* 输出对手状态 */
        if ($damage > 0) {
		    if ($bounce > 0) {
                $this->report_status($me, 0);
                }
		    else { 
                $this->report_status($victim, $wounded);
            }
            
            if (!$me->is_killing($victim->id) && !$victim->is_killing($me->id) && (($victim->query("kee") * 2 <= $victim->query("max_kee")) )) {
                $me->remove_enemy($victim);
                $victim->remove_enemy($me);
			    $this->fight_reward($me, $victim);
			    $this->fight_penalty($me, $victim);			
                msg::message('vision', $this->winner_msg[rand(0, count($this->winner_msg) - 1)], $me ,$victim);
            }
        }

        if (isset($action["post_action"])) {
            $action_function = $action["post_action"];
            $weapon->$action_function($me, $victim, $damage);
        }
    }

    private function report_status($ob, $effective = 0)
    {
        if ($effective) 
            msg::message('vision','（$N' . $this->eff_status_msg($ob->query("eff_kee") * 100 / $ob->query("max_kee")) . '）', $ob); 
        else
            msg::message('vision','（$N' . $this->status_msg($ob->query("kee") * 100 / $ob->query("max_kee")) . '）', $ob); 
    }

    public function fight_reward($winner, $loser)
    {
        if (null != $winner->query("possessed"))
            $winner = $winner->query("possessed");
        $winner->win_enemy($loser);
    }
    
    public function fight_penalty($winner, $loser)
    {
        if(null != $loser->query("possessed"))
            $loser = $loser->query("possessed");
        $loser->lose_enemy($winner);
    }

    public function announce($ob, $event)
    {
        switch($event) {
            case "dead":
                msg::message('vision', '$N死了。', $ob);
                break;
            case "unconcious":
                msg::message('vision', '$N脚下一个不稳，跌在地上一动也不动了。', $ob);
                break; 
            case "revive":
                msg::message('vision', '$N慢慢睁开眼睛，清醒了过来。', $ob);
                break;
        }
    }

    public function killer_reward($killer, $victim)
    {
        $realkiller = $killer;
        if (null != $killer->query('possessed')) 
            $killer = $killer->query('possessed');

        $killer->killed_enemy($victim);

        if ($victim->is_player()) {
		    if ($killer->query("combat_exp") < $victim->query("combat_exp") / 10 * 9)
		        $killer->set("last_good_kill",intval($killer->query("mud_age")));	
                $killer->add("PKS", 1);
                $bls = 10;
        } else {
                $killer->add("MKS", 1);
                $bls = 1;
        }

        global $CHINESE_D;

        $killer->add("bellicosity", $bls);
        /* quest奖励 */
        if (null != $killer->query("quest") && is_array($killer->query("quest")))
        {
            $quest = $killer->query("quest");
            if ($killer->query("quest_time") >= time() && ($victim->query('name') == $quest["quest"]) && !$victim->is_player())
            {
                $exp = $quest["exp_bonus"] / 2 + rand(0, $quest["exp_bonus"] / 2);
                if ($exp > 100) 
                    $exp = 100;
                if ($killer->query_temp("quest_number") == null)
                    $killer->set_temp('quest_number', 1);
                $exp = $exp * $killer->query_temp("quest_number");
                $pot = $exp / 5 + 1;
        
                $score = -1;
                /* quest为个人任务，不计算队伍成员奖励 */
                $killer->add("combat_exp", intval($exp));
                $killer->add("potential", intval($pot));
                $killer->add("score", $score);
                $killer->get_conn()->ssend("HIW你被奖励了：<br>" . $CHINESE_D->chinese_number(intval($exp)) . "点实战经验<br>" . $CHINESE_D->chinese_number(intval($pot)) . "点潜能NOR");
                $killer->del("quest");
            }           
        }
        else {
            $quest = $killer->query("quest");
            if ($killer->query("task_time") >= time() && ($victim->name() == $quest) && !$victim->is_player())
            {
                $exp = rand(0, 100) + 10;
                $exp = $exp * $killer->query_temp("quest_number") / 5;
                $pot = $exp / 5 + 1;
        
                $score = -1;
                /* quest为个人任务，不计算队伍成员奖励 */
                $killer->add("combat_exp", intval($exp));
                $killer->add("potential", intval($pot));
                $killer->add("score", score);
                $killer->get_conn->ssend("HIW你被奖励了：<br>" . $CHINESE_D->chinese_number(intval($exp)) . "点实战经验<br>" . $CHINESE_D->chinese_number(intval($pot)) . "点潜能NOR");
                $killer->del("quest");
            }           
        }
        if (!$realkiller->is_player && $realkiller->query("hired_killer") && $victim->query("id") == $realkiller->query("haunttar")) {
            msg::message('vision', '$N一拱手：幸不辱使命！后会有期！', $realkiller);
            $realkiller->destruct();
        }
    }

    public function victim_penalty($victim, $killer)
    {
        $msg = "莫名其妙地死了。";
        if ($victim->is_player()) { 
		    $victim->add("KILLED", 1);
        }
        if(isset($killer) && $killer->is_character()) {
    		$msg = "被" . $killer->name;
		    $actions = $killer->query("actions");
            /* 武器的action是一种，默认的action可能是多种 */
            if (!isset($actions['damage_type'])) {
                $i = rand(0, count($actions) - 1);
                $actions = $actions[$i];
            }

		    switch($actions["damage_type"]) {
		        case "拉伤":
	            case "割伤":
			        $msg .= "砍死了。";
			        break;
		        case "刺伤":
			        $msg .= "刺死了。";
			        break;
		        case "瘀伤":
			        $msg .= "击死了。";
                    break;
		        case "抓伤":
			        $msg .= "抓死了。";
			        break;
		        case "反弹伤":
                    $msg .= "震死了。";
                    break;
		        default:
			        $msg .= "杀死了。";
		    }
        }
        msg::channel("rumor", $victim->name . $msg, $victim);
        if ($env = $victim->get_env()) {
            if ($env->query_temp('no_death_penalty'))
                $victim->set_temp('no_death_penalty', 1);
            else {
                /* 玩家死亡惩罚 */    
                $victim->set("bellicosity", 0);             
                $victim->del("vendetta");
                if ($victim->query('combat_exp') > NEW_COMBAT_EXP) {
                    $victim->add("combat_exp", -(intval($victim->query("combat_exp") / 50)));
                    if ($victim->query("potential") > 0)
                        $victim->set("potential", intval($victim->query("potential") / 2));
                        $victim->skill_death_penalty();
                }
            }
        }
	}	

    public function start_hatred($me, $victim)
    {
        if ($me->get_env() != $victim->get_env())
            return false;
        
        $room = $me->get_env();
        if (null != $room->query('no_fight'))
            return false;

        if ($me->query_temp('is_unconcious') != null)
            return false;

        msg::message('vision', $this->catch_hunt_msg[rand(0, count($this->catch_hunt_msg) - 1)], $me, $victim);
        $me->kill_ob($victim);
    }
}
