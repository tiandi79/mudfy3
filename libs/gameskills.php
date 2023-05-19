<?php
/**
*  skill物件
*
*/
namespace libs;

class gameskills
{
    private $_instance, $_pfms, $_exerts, $_casts;

    function __construct()
    {

    }

    public function get($key)
    {
        if (isset($this->_instance[$key]))
            return $this->_instance[$key];
        else {
            $classname = SKILL_D.$key;
            $skill = new $classname();
            if (!isset($skill->type))
                $skill->type = 'normal';
            $this->_instance[$key] = $skill;
            return $skill;
        }
    }

    public function get_pfm($skill, $key, $skilltype)
    {
        if (isset($this->_pfms[$skilltype . '.' . $key]))
            return $this->_pfms[$skilltype . '.' . $key];
        else {
            $classname = $skill->perform_action_file($key);
            $classname = str_replace('/', '\\', $classname);
            if (!file_exists(ROOT_DIR. $classname . '.php'))
                return false;
            $pfm_action = new $classname();
            $this->_pfms[$skilltype . '.' . $key] = $pfm_action;
            return $pfm_action;
        }
    }

    public function get_exert($skill, $key)
    {
        if (isset($this->_exerts[$key]))
            return $this->_exerts[$key];
        else {
            $classname = $skill->exert_action_file($key);
            $classname = str_replace('/', '\\', $classname);
            if (!file_exists(ROOT_DIR. $classname . '.php'))
                return false;
            $exert_action = new $classname();
            $this->_exerts[$key] = $exert_action;
            return $exert_action;
        }
    }

    public function get_cast($skill, $key)
    {
        if (isset($this->_casts[$key]))
            return $this->_casts[$key];
        else {
            $classname = $skill->cast_action_file($key);
            $classname = str_replace('/', '\\', $classname);
            if (!file_exists(ROOT_DIR. $classname . '.php'))
                return false;
            $cast_action = new $classname();
            $this->_casts[$key] = $cast_action;
            return $cast_action;
        }
    }
}