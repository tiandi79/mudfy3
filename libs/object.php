<?php
/**
*  物件存放处
*
*/
namespace libs;

class object
{
    public $_rooms = array();
    public $_objs = array();

    function __construct()
    {
        
    }

    public function find_living($arg)
    {
        foreach ($this->_objs as $v) {
            if ($v->id == $arg && $v->is_character())
                return $v;
        }
        return false;
    }

    public function find_object($arg, $isTask = true)
    {
        foreach ($this->_objs as $v) {
            if ($v->id == $arg && !$v->is_character()) {
                if (!$isTask)
                    return $v;
                elseif ($isTask && ($v->query('dynamic_quest') != null))
                    return $v;
                else
                    return false;
            }
        }
        return false;
    }

    public function add_user($oid ,$user)
    {
        if (!isset($this->_objs[$oid])) {
            $user->oid = $oid;
            $this->_objs[$oid] = $user;
            return true;
        }
        else 
            return false;
    }

    public function update_user($user)
    {
        $this->_objs[$user->oid] = $user;        
    }   

    public function remove_user($user)
    {
        if (isset($this->_objs[$user->oid])) {
            unset($this->_objs[$user->oid]);
            return true;
        }
        else 
            return false;
    }   

    public function get_objects($oid)
    {
        if (isset($this->_objs[$oid]))
            return $this->_objs[$oid];
        else 
            return null;
    }

    public function remove_object($obj)
    {
        if (isset($this->_objs[$obj->oid])) {
            unset($this->_objs[$obj->oid]);
            return true;
        }
        else 
            return false;
    }

    public function create_objects($key)
    {
        if (substr($key, 0, 1) != '/') {
            $key = str_replace('/', '\\', '/'. $key);
            $key = substr($key, 1);
            
            if (substr($key, 0 , 1) != '\\') {
                if (!stristr($key, D_DIR))
                    $key = D_DIR . $key;
            }
        }
        else {
            $key = substr($key, 1);
            $key = str_replace('/', '\\', '/'. $key);
            $key = substr($key, 1);
        }

        global $GAME;
        $object = new $key();
        $object->oid = $GAME->oid;
        $GAME->oid++;
        $this->_objs[$object->oid] = $object;
       // echo "\n create objects ". $key . ' at oid ' . $object->oid; 
        return $object;
    }

    public function get_room($key)
    {
        $key = str_replace('/', '\\', '/'. $key);
        $key = substr($key, 1);
        if (!stristr($key, D_DIR))
            $key = D_DIR . $key;

        if (isset($this->_rooms[$key])) {
         //   echo "\n get room ". $key . ' at oid ' . $this->_rooms[$key]->oid;
            return $this->_rooms[$key];
        }
        else {
            global $GAME;
            $object = new $key($GAME->oid);
            $object->oid = $GAME->oid;
            $GAME->oid++;
            $object->id = $key;
            $this->_rooms[$key] = $object;
       //     echo "\n create room ". $key . ' at oid ' . $object->oid;
            return $object;
        }
    }

    public function update_room($key)
    {   
        global $GAME;

        if (!isset($this->_rooms[$key])) {
            $object = new $key($GAME->oid);   
            $GAME->oid++;
            $object->id = $key;
            $this->_rooms[$key] = $object;
            return $object;
        }
        else {
            $old = $this->_rooms[$key];
            $oldenv = $old->all_inventory();
            foreach ($oldenv as $k => $v) {
                /* 如果TASK就在房间地上，则不清除  */
                if ($v->query('istask'))
                    continue;

                if (!$v->is_player()) {
                    /* 先移除物件身上的物件，只管一层 */
                    $objenv = $v->all_inventory();
                    $has_task = false;
                    $ready_to_remove = array();
                    foreach ($objenv as $vv) {
                        /* 如果该物件携带TASK，则做标记，不再检查该物件剩余携带物件 */
                        if ($vv->query('istask')) {
                            $has_task = true;
                            break;
                        }
                        $ready_to_remove[] = $vv;   
                        //$this->remove_object($vv);
                    }
                    if (!$has_task) {
                        /* 释放子物件 */
                        foreach ($ready_to_remove as $removeitem) {
                            $this->remove_object($removeitem);
                            $removeitem->destruct();
                        }
                        /* 释放旧场景非玩家物件 */
                        $this->remove_object($v);
                        $v->destruct();
                        unset($v);
                        /* oldenv只保留玩家物件和TASK物件以便移入新场景 */
                        unset($oldenv[$k]);
                    } else {
                        /* 如果该物件携带TASK，则清空待释放子物件数组 */
                        unset($ready_to_remove);
                    }
                }
            }
            /* 删除旧场景信息 */
            unset($this->_room[$key]);
            $object = new $key($GAME->oid);
            $GAME->oid++;
            $object->id = $key;
            $this->_rooms[$key] = $object;
            
            foreach ($oldenv as $v) {
                /* 将玩家和TASK重新移入新场景 */
                if ($v->is_player() || $v->query('istask')) {
                    $v->move($object, true);
                }
                else {
                    /* 携带task的物件处理，需要清除房屋更新后重名 */
                    echo "npc " . $v->query('id') . " move to " . $object->query('name') . "\n";
                    $objenv = $object->all_inventory();
                    foreach ($objenv as $single) {
                        if (($single->query('id') == $v->query('id')) && ($single->query('name') == $v->query('name'))) {
                            echo $single->query('id') . " bring task.\n"; 
                            $this->remove_object($single);
                            $single->destruct();
                            break;
                        }
                    }
                    $v->move($object, true);
                }
            }
            return $object;
        }
    }
}
