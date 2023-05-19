<?php
/**
*  condition物件
*
*/
namespace libs;

class conditions
{
    private $_instance;

    function __construct()
    {

    }

    public function get($key)
    {
        if (isset($this->_instance[$key]))
            return $this->_instance[$key];
        else {
            $classname = CONDITION_D.$key;
            $condition = new $classname();

            $this->_instance[$key] = $condition;
            return $condition;
        }
    }
}
