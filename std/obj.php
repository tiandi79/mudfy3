<?php
/**
*  物件对象
*
*/
namespace std;

use \Workerman\Lib\Timer;

class obj
{
    public $carry_objects = array();
    public $have_heart = false;
    public $temp = array();
    public $type = 'obj';
    public $prep = 'inside';
    public $is_live = false;
    public $is_character = false;
    public $is_player = false;
    public $is_ghost = false;
    public $is_zombie = false;
    public $is_corpse = false;
    public $is_close = false;
    public $timerid;
    public $timertype;
    public $amount = 0;
    public $base_name;
    public $encumbrance = 0;
    public $value = 0;
    public $weight = 1;
    public $marks;

    function __construct()
    {
        $this->base_name = get_class($this);
    }

    public function get_basename($flag = null)
    {
        if ($flag)
            return '\\' . $this->base_name;
        else
            return $this->base_name;
    }

    public function is_container()
    {
        return false;
    }

    public function is_close()
    {
        return $this->is_close;
    }

    public function query_amount()
    {
        return $this->amount;
    }

    public function add_amount($amount)
    {
        $amount =  $this->query_amount() + $amount;
        if ($amount < 1) {
            $this->destruct();
        }
        else
            $this->set_amount($amount);
    }

    public function set_amount($amount)
    {
        global $CHINESE_D;
        $this->amount = $amount;
        $this->set_weight($amount * $this->query("base_weight"));
        $this->set('value', $amount * $this->query('base_value'));
        $this->set('short', $CHINESE_D->chinese_number($this->query_amount()) . $this->query('base_unit') . $this->query('name') . '(' . $this->query('id') . ')'); 
    }

    public function living()
    {
        return $this->is_live;
    }

    public function is_corpse()
    {
        return $this->is_corpse;
    }

    public function is_character()
    {
        return $this->is_character;
    }

    public function is_zombie()
    {
        return $this->is_zombie;
    }

    public function is_ghost()
    {
        return $this->is_ghost;
    }

    public function is_player()
    {
        return $this->is_player;
    }

    public function query_temp($key)
    {
        if (isset($this->temp[$key]))
            return $this->temp[$key];
        else
            return null;
    }

    public function set_temp($key, $value)
    {
        $this->temp[$key] = $value;
        return true;
    }

    public function del_temp($key)
    {
        if (isset($this->temp[$key]))
            unset($this->temp[$key]);
        return true;
    }

    public function query($key)
    {
        if (isset($this->$key)) {
            if ($key == 'id' || $key == 'name' || $key == 'gender') {
                if ($this->query_temp('apply/' . $key) != null) {
                    return $this->query_temp('apply/' . $key);
                }
            }
            return $this->$key;
        }
        else
            return null;
    }

    public function set($key, $value)
    {
        if ($key == 'temp' || $key == 'marks' || $key == 'mystorys')
            return false;
        $this->$key = $value;
        return true;
    }

    public function del($key)
    {
        if ($key == 'temp' || $key == 'marks' || $key == 'mystorys')
            return false;
        if (isset($this->$key))
            unset($this->$key);
        return true;
    }

    public function all_inventory()
    {
        return $this->carry_objects;
    }

    public function is_carry($target)
    {
        foreach ($this->carry_objects as $v) {
            if ($v->id == $target)
                return $v;
        }
        return false;
    }

    public function set_carry($object)
    {
        if (!isset($object->oid))
            return false;
        $this->carry_objects[$object->oid] = $object;
        /* 物件的负重等于子物件的重量加上子物件的负重，不计入物件本身重量 */
        $this->set_encumbrance($object->query_weight() + $this->query_encumbrance());
        return true;
    }

    public function unset_carry($object)
    {
        if (!isset($object->oid)) {
            return false;
        }

        if (isset($this->carry_objects[$object->oid])) {
            $this->set_encumbrance($this->query_encumbrance() - $object->query_encumbrance() - $object->query_weight());
            if ($this->query_encumbrance() < 0)
                $this->set_encumbrance(0);
            unset($this->carry_objects[$object->oid]);
        }
        return true;
    }

    public function get_env()
    {
        return $this->place;
    }

    public function move($object, $silence = false)
    {
        if (null != $this->query('equipped')) {
            $char = $this->get_env();
            $char->unequip($this);
        }

        if (($this->query_encumbrance() + $this->query_weight()) > $object->query_max_encumbrance()) {
            if ($object->is_player()) {
                $object->get_conn()->ssend('这个东西对你来说太重了。');
                return false;
            }
        }

        if ($object->set_carry($this)) {
            if (isset($this->place) && $this->place !== $object)
                $this->place->unset_carry($this);
            $this->place = $object;
            return true;
        }
        else 
            return false;
    }

    /* 对象是否在用户所在场景 
    /* param $target string 对象id
    /* return object
    */
    public function is_environment($target)
    {
        $env = $this->get_env();
        $objs = $env->all_inventory();
        foreach ($objs as $k => $v) {
            if ($v->query('id') == $target) {
                return $v;
            }   
        }
        return false;
    }

    public function add($key, $value)
    {
        if (isset($this->$key))
            $this->$key += $value;
        else
            $this->$key = $value;
        return $this->$key;
    }

    public function add_temp($key, $value)
    {
        if (isset($this->temp[$key]))
            $this->temp[$key] += $value;
        else
            $this->temp[$key] = $value;
        return $this->temp[$key];
    }


    public function destruct()
    {
        /* 有计时器先删除 */
        if (isset($this->timeid))
            Timer::del($this->timeid);

        /* 物件包含子物件时，先删除子物件 */
        if (null != $this->all_inventory()) {
            $objs = $this->all_inventory();
            foreach ($objs as $k => $v) {
                if (!$v->is_player())
                    $v->destruct();
            }
        }
        /* 如果存在用户，则不释放场景 */
        if (null != $this->all_inventory())
            return false;
        
        /* 如果物件被装备，则先卸下 */
        if (null != $this->query('equipped')) {
            $char = $this->get_env();
            $char->unequip($this);       
        }
        
        /* 物件如果有场景，则删除场景信息 */
        global $OBJECT;
        if (isset($this->place)) {
            $this->place->unset_carry($this);
        }
        $OBJECT->remove_object($this);
    }

    public function owner_is_killed($killer)
    {
        return true;
    }

    public function set_weight($value)
    {
        $this->weight = $value;
    }

    public function query_weight()
    {
        return $this->weight;
    }

    public function query_max_encumbrance()
    {
        if (isset($this->max_encumbrance))
            return $this->max_encumbrance;
    }

    public function set_max_encumbrance($max_encumbrance)
    {
        $this->max_encumbrance = $max_encumbrance;
        return true;
    }

    public function query_encumbrance()
    {
        return $this->encumbrance;
    }

    public function set_encumbrance($encumbrance)
    {
        $this->encumbrance = $encumbrance;
        return true;
    }

    public function over_encumbranced()
    {
        return false;
    }

    public function call_out($s, $func, $param, $class = null)
    {
        $use_timer = false;
        if (!is_array($param))
            $param = array($param);
        
        if ($func == 'greating') {
            $use_timer = true;
        } elseif (substr($func, 0, 7) == 'remove_') {
            $use_timer = true;
        } elseif ($func == 'next_stage') {
            $use_timer = true;
        } elseif ($func == 'close_path') {
            $use_timer = true;
        } elseif ($func == 'kill_him') {
            $use_timer = true;
        } elseif ($func == 'decay') {
            $use_timer = true;
        } elseif ($this->query('type') == 'room') {
            $use_timer = true;
        }

        if ($use_timer) {
            if ($class)
                $this->timerid = Timer::add($s, array($class, $func), $param, false);
            else
                $this->timerid = Timer::add($s, array($this, $func), $param, false);
        } else {
            /* 技能condition 参数说明 
            /  param[0] 为user
            /  param[1] 为condition名称
            /  param[2] 为提升的值
            **/
            if (isset($this->conditions)) {
                $nexttime = time() + $s;
                $this_class = isset($class) ? $class : $this;
                $condition = array('next_time' => $nexttime, 'func' => $func, 'param' => $param, 'this_class' => $this_class);
                $this->apply_condition($condition);
            }
        }
    }  
}
