<?php
/**
*  地点定义
*
*/

namespace std;

use std\msg;

class room extends obj
{
    public $max_encumbrance = 999999999;
    public $short;
    public $long;
    public $exits;
    public $id;
    public $oid;
    public $type = 'room';
    public $door;

    function __construct($oid = null) 
    {
        parent::__construct();
        if (isset($oid)) {
            $this->oid = $oid;
        }
    }
    
    /* 房门状态，0为开，1为关  */
    public function query_door($direction)
    {
        if (!isset($this->door[$direction]))
            return false;
        elseif ($this->door[$direction]['status'] == 0)
            return 0;
        elseif ($this->door[$direction]['status'] == 1)
            return 1;
    }

    public function valid_enter()
    {
        return true;
    }

    public function setup_room()
    {
        if (isset($this->objects)) {
            $objs = $this->objects;
            global $OBJECT, $GAME;
            foreach ($objs as $k => $v) {
                for ($i = 0;$i < $v;$i++) {
                    $obj = $OBJECT->create_objects($k);
                    $obj->move($this);
                }
            }
        }
    }

    public function create_door($side, $desc, $other_side, $status)
    {
        $this->door[$side]['status'] = $status;
        $this->door[$side]['desc'] = $desc;
        $this->door[$side]['out'] = $side;
        $this->door[$side]['in'] = $other_side;
    }

    private function get_side_room($arg)
    {
        global $OBJECT;
        /* 当前room的该方向不存在 */
        if (!isset($this->exits[$arg]))
            return false;
        else {
            /* 获取方向所在的room */
            $room2 = $OBJECT->get_room($this->exits[$arg]);
            /* 该方向room不存在 */
            if (!isset($room2))
                return false;
            else {
                /* 该方向room里没有door */
                if (!isset($room2->door))
                    return false;
                else {
                    return $room2;
                }
            }
        }   
    }

    public function do_look($ob, $arg)
    {
        if (!isset($arg))
            return false;

        if ($arg == 'door') {
            if (count($this->door) == 0)
                return false;
            foreach ($this->door as $k => $v) {
                $arg = $k;
                break;
            }
        }
        
        if (!isset($this->door[$arg]))
            return false;
        $status = $this->door[$arg]['status'];

        if ($status == 1)
            $ob->ssend('这个方向的门是关着的。');
        else
            $ob->ssend('这个方向的门是开着的。');
        return true;
    }

    public function do_open($ob, $arg)
    {
        if (!isset($arg))
            return false;

        if ($arg == 'door') {
            if (count($this->door) == 0)
                return false;
            foreach ($this->door as $k => $v) {
                $arg = $k;
                break;
            }
        }

        if (null == $this->door[$arg])
            return false;
        
        $status = $this->door[$arg]['status'];
        if ($status == 0) {
            $ob->ssend('这个方向的门已经是开着的。');
        } else { 
            $this->door[$arg]['status'] = 0;
            msg::message('vision', '$N将' . $this->door[$arg]['desc'] . '打开了。', $ob->body);
            /* 同步相邻房间的门状态 */
            $room = $this->get_side_room($arg);

            if ($room && null != $room->door[$this->door[$arg]['in']]) {
                $room->door[$this->door[$arg]['in']]['status'] = 0;
                $objs = $room->all_inventory();
                foreach ($objs as $v) {
                    if ($v->is_player()) {
                        msg::message_text('vision', '有人从对面将' . $this->door[$arg]['desc'] . '打开了。', $v);
                        break;
                    }
                }
            }

        }
        return true;
    }

    public function do_close($ob, $arg)
    {
        if (!isset($arg))
            return false;

        if ($arg == 'door') {
            if (count($this->door) == 0)
                return false;
            foreach ($this->door as $k => $v) {
                $arg = $k;
                break;
            }
        }

        if (null == $this->door[$arg])
            return false;
        
        $status = $this->door[$arg]['status'];
        if ($status == 1) {
            $ob->ssend('这个方向的门已经是关着的。');
        } else {
            $this->door[$arg]['status'] = 1;
            msg::message('vision', '$N将' . $this->door[$arg]['desc'] . '关上了。', $ob->body);
            /* 同步相邻房间的门状态 */
            $room = $this->get_side_room($arg);
            if ($room && null != $room->door[$this->door[$arg]['in']]) {
                $room->door[$this->door[$arg]['in']]['status'] = 1;
                $objs = $room->all_inventory();
                foreach ($objs as $v) {
                    if ($v->is_player()) {
                        msg::message_text('vision', '有人从对面将' . $this->door[$arg]['desc'] . '关上了。', $v);
                        break;
                    }
                }
            }

        }
        return true;
    }
}
