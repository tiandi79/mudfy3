<?php
/**
*  车崩狱
*
*/
namespace d\death;

use std\room;

class chebeng extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '车崩狱');
        $this->set('long', '恰似战国时候的五马分尸，也称车裂，育两种，一种是将罪犯四肢套在五辆车车辕上，然后众车背到而驰，一种是以千斤战车碾轧人身，就算铁打金刚也会分成数段。此刑在人间早以废除不用，不想在地狱尚能一见，此刑酷烈，想来此间犯人的罪必大到极点。再往下又是一类犯人了，又当如何呢？');
        $this->set('exits', array("up" => "death/zhuidao",
            'down' => 'death/hanbing'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -190);

        parent::setup_room();
    }
}
