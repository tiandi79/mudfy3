<?php
/**
*  default conn
*
*/
namespace libs;

class conn
{
    public $body;
    function __construct()
    {

    }

    public function ssend($s)
    {
        return false;
    }

    public function init($t)
    {
        $this->body = $t;
    }
}
