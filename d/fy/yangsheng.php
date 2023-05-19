<?php
/**
*  养生舍
*
*/
namespace d\fy;

use std\room;

class yangsheng extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '养生舍');
        $this->set('long', '养生舍四壁皆空，唯墙上书道：不有中有，不无中无。不色中色，不空中空。非有为有，非无为无。色非为色，非空为空。空即是色，色即是色。色无定色，色即是空。空无定空，空即是色。知空不空，知色不色。');
        $this->set('exits', array("south" => "fy/pusheng"));
      //  $this->set('objects', array('d/fy/npc/huofe' => 1));
        $this->set('coor/x', -10);
        $this->set('coor/y', -49);
        $this->set('coor/z', 0);

        parent::setup_room();
    }
}
