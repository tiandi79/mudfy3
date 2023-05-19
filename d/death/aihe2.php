<?php
/**
*  奈河桥
*
*/
namespace d\death;

use std\room;

class aihe2 extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '奈河桥');
        $this->set('long', '此桥桥边便是焦都驿驿，桥和驿站一样，通跨阴阳，左段青天白日，右段却隐没在黑雾之中，桥下的泾河形式险恶，奔流不息，浪声不绝，在黑水之中隐约可见人影幢幢，古来到此因惊吓落水者不计其数。再往前便是鬼门关了。');
        $this->set('exits', array("west" => "death/gate",
            'east' => 'death/ghostinn'));

        $this->set('objects', array("death/npc/ghost" => 5,
            'death/npc/mamian' => 1,
            'death/npc/niutou' => 1));

        $this->set('coor/x', -1010);
        $this->set('coor/y', 0);
        $this->set('coor/z', -100);

        parent::setup_room();
    }
}
