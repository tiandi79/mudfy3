<?php
/**
*  拔舌狱
*
*/
namespace d\death;

use std\room;

class bashe extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '拔舌狱');
        $this->set('long', '自古以来奸恶之徒，不孝之人多爱搬弄是非，佛口蛇心，故设拔舌狱，以七寸长箝勾去舌头，使之口不能言，舌会复长，长而再拔，往复循环，直至犯人心胆皆丧，来世为人，便不敢再犯此业。再往下便是剥皮狱。');
        $this->set('exits', array("up" => "death/yandu",
            'down' => 'death/bopi'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -150);

        parent::setup_room();
    }
}
