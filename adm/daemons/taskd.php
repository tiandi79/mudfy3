<?php
/**
*  TASK分配
*
*/
namespace adm\daemons;

class taskd
{
    public $tasks, $locations, $last_time;
    function __construct()
    {
        $this->tasks = require_once(ROOT_DIR . 'quest/dynamic_quest.php'); 
        $this->locations = require_once(ROOT_DIR . 'quest/dynamic_location.php'); 
        $this->init_dynamic_quest(1);
        $this->last_time = time();
    }

    /** task 重新分配
    /*
    /* $forced 强制重新分配
    */
    public function init_dynamic_quest($forced = 0)
    {
	    for ($i = 0; $i < count($this->tasks); $i++)
		    $this->spread_quest($this->tasks[$i], $forced);
    }

    private function spread_quest($task, $forced)
    {
        global $OBJECT;
        $this_task = $OBJECT->find_object($task['id']);

        if ($this_task && !$forced) {
            return;
        }
        if ($this_task) {
            $this_task->destruct();
        }
        $location = $this->locations[rand(0, count($this->locations) - 1)];
        
        $room = $OBJECT->get_room($location);
        $target = array();
        if ($room) {
            $inv = $room->all_inventory();
            foreach ($inv as $k => $v) {
                if ($v->is_character() && !$v->is_player())
                    $target[] = $v;
                elseif ($v->is_container())
                    $target[] = $v;
            }
        }
        
        if (count($target)) {
            $room = $target[rand(0, count($target) - 1)];
        }
        $this_task = $OBJECT->create_objects($task["file_name"]);
	    $this_task->set("value", 0);
	    $this_task->set("dynamic_quest", $task);
	    $this_task->move($room);		
       // echo "\ntask=".$this_task->id. ",loc=". $room->id . ",len=".count($target)."\n";
    }

    private function already_spreaded($task_file, $forced)
    {

    }

    public function quest_reward($me, $who, $obj)
    {
        $quest = $obj->query('dynamic_quest');
        if ($who->get_basename() != $quest['owner_file_name'])
            return false;
        $exp = 200 + rand(0, 500);
        $pot = intval($exp / 7);
        $score = rand(0, 10) + 1;
        $me->add('combat_exp', $exp);
        $me->add('potential', $pot);
        $me->add('score', $score);
        global $CHINESE_D;
        $me->get_conn()->ssend('你被奖励了：<br>' . $CHINESE_D->chinese_number($exp) . '点实战经验<br>' . $CHINESE_D->chinese_number($pot) . '点潜能<br>' . $CHINESE_D->chinese_number($score) . '点综合评价');
        $me->add('task', 1);
        if (method_exists($obj, 'extra'))
            $obj->extra($me, $who);
        $obj->destruct();
        return true;
    }

    public function dyn_quest_list()
    {
        global $OBJECT;
	    $output = '';
        for ($i = 0; $i < count($this->tasks); $i++) {          
            $task = $OBJECT->find_object($this->tasks[$i]['id']);
            if ($task) {
                if (rand(0, 1))
                    $output .= $this->tasks[$i]['owner_name'] . '的' . $this->tasks[$i]['name'] . '(' . $this->tasks[$i]['id'] . ')<br>';
                else
                    $output = $this->tasks[$i]['owner_name'] . '的' . $this->tasks[$i]['name'] . '(' . $this->tasks[$i]['id'] . ')<br>' . $output;
            } else {
                if (rand(0, 1))
                    $output .= $this->tasks[$i]['owner_name'] . '的' . $this->tasks[$i]['name'] . '(' . $this->tasks[$i]['id'] . ')〔已完成〕<br>';
                else
                    $output = $this->tasks[$i]['owner_name'] . '的' . $this->tasks[$i]['name'] . '(' . $this->tasks[$i]['id'] . ')〔已完成〕<br>' . $output;
            }
        }
        return $output;
    }

    public function locate_obj($me, $item) {
        global $OBJECT, $GAME;
        $distance = array("极近", "很近", "比较近", "不远", "不近", "比较远", "很远", "极远");
        $directions = array("周围","北方", "南方", "东方","西方", "东北方","西北方","东南方","西南方");
        $altitude = array("高处", "地方", "低处");

        $itemname = '';
        $task = '';
        for ($i = 0; $i < count($this->tasks); $i++) {
            if ($this->tasks[$i]['id'] == $item) {
                $task = $OBJECT->find_object($item);
                if ($task) {
                    $itemname = $this->tasks[$i]['name'];       
                }
            }           
        }
        /* 如果是TASK，并且未完成 */
        if ($itemname) {
            $place = $me->place;
            $room = $OBJECT->get_room($place->id);
            $targetroom = $task->get_env();
            while ($targetroom->type !== 'room') {
                $targetroom = $targetroom->get_env();
            }

            $x = $room->query('coor/x');
            $y = $room->query('coor/y');
            $z = $room->query('coor/z');

            $x = $targetroom->query('coor/x') - $x;
            $y = $targetroom->query('coor/y') - $y;
            $z = $targetroom->query('coor/z') - $z;
            
            /* 距离等级 */
            $realdis = 0;
            if ($x < 0) 
                $realdis -= $x;
            else
                $realdis += $x;

            if ($y < 0) 
                $realdis -= $y;
            else
                $realdis += $y;

            if ($z < 0) 
                $realdis -= $z;
            else
                $realdis += $z;
            
            $realdis = intval($realdis / 50);
            if ($realdis > 7)
                $realdis = 7;            
            $dis = $distance[$realdis];

            /* 高度等级 */
            if ($z > 0)
                $alt = $altitude[0];
            elseif ($z < 0)
                $alt = $altitude[2];
            else
                $alt = $altitude[1];

            if ($x == 0 && $y == 0)
                $dir = $directions[0];
            elseif ($x == 0 && $y > 0)
                $dir = $directions[1];
            elseif ($x == 0 && $y < 0)
                $dir = $directions[2];
            elseif ($x > 0 && $y == 0)
                $dir = $directions[3];
            elseif ($x < 0 && $y == 0)
                $dir = $directions[4];
            elseif ($x > 0 && $y > 0)
                $dir = $directions[5];
            elseif ($x < 0 && $y > 0)
                $dir = $directions[6];
            elseif ($x > 0 && $y < 0)
                $dir = $directions[7];
            elseif ($x < 0 && $y < 0)
                $dir = $directions[8];
            $output = '『' . $itemname . '』似乎在' . $dir . $dis . '的' . $alt . '。';
            return $output;
        }

        $dir = '';
        $dis = '';
        $alt = '';
        $itemname = '';

        /* 定位人 */
        if ($me->wizardp() || $me->query('class') == 'official') {
            $who = $GAME->find_player($item);
            if (!$who) {
                $who = $OBJECT->find_living($item);
                if (!$who)
                    return '';
            }

            if ($who) {
                $place = $me->place;
                $room = $OBJECT->get_room($place->id);
                $targetroom = $who->get_env();
                while ($targetroom->type !== 'room') {
                    $targetroom = $targetroom->get_env();
                }

                $x = $room->query('coor/x');
                $y = $room->query('coor/y');
                $z = $room->query('coor/z');

                $x = $targetroom->query('coor/x') - $x;
                $y = $targetroom->query('coor/y') - $y;
                $z = $targetroom->query('coor/z') - $z;
                
                /* 距离等级 */
                $realdis = 0;
                if ($x < 0) 
                    $realdis -= $x;
                else
                    $realdis += $x;

                if ($y < 0) 
                    $realdis -= $y;
                else
                    $realdis += $y;

                if ($z < 0) 
                    $realdis -= $z;
                else
                    $realdis += $z;
                
                $realdis = intval($realdis / 50);
                if ($realdis > 7)
                    $realdis = 7;            
                $dis = $distance[$realdis];

                /* 高度等级 */
                if ($z > 0)
                    $alt = $altitude[0];
                elseif ($z < 0)
                    $alt = $altitude[2];
                else
                    $alt = $altitude[1];

                if ($x == 0 && $y == 0)
                    $dir = $directions[0];
                elseif ($x == 0 && $y > 0)
                    $dir = $directions[1];
                elseif ($x == 0 && $y < 0)
                    $dir = $directions[2];
                elseif ($x > 0 && $y == 0)
                    $dir = $directions[3];
                elseif ($x < 0 && $y == 0)
                    $dir = $directions[4];
                elseif ($x > 0 && $y > 0)
                    $dir = $directions[5];
                elseif ($x < 0 && $y > 0)
                    $dir = $directions[6];
                elseif ($x > 0 && $y < 0)
                    $dir = $directions[7];
                elseif ($x < 0 && $y < 0)
                    $dir = $directions[8];
                $output = '『' . $who->query('name') . '』似乎在' . $dir . $dis . '的' . $alt . '。';
                return $output;
            }
        return '';
        }
    }
}
