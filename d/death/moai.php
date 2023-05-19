<?php
/**
*  磨捱狱
*
*/
namespace d\death;

use std\room;

class moai extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '磨捱狱');
        $this->set('long', '一进来，满鼻的血腥味，几只大磨盘不停的转动着，推磨的赤发鬼累得满头大汗，不时擦拭着。这里是“皮开肉绽，抹嘴呲牙，乃是瞒心昧己不公道，巧语花言暗伤人”的人犯受刑之地，人犯轮流被推上磨盘，榨为肉酱，然后再由黑面鬼放入陶盆，拼凑起来，重塑人形后继续受刑。想来下面的椎捣狱也不会舒服到哪里。');
        $this->set('exits', array("up" => "death/bopi",
            'down' => 'death/zhuidao'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -170);

        parent::setup_room();
    }
}
