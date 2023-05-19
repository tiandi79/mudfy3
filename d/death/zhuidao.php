<?php
/**
*  椎捣狱
*
*/
namespace d\death;

use std\room;

class zhuidao extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '椎捣狱');
        $this->set('long', '迎面就是几个巨人，手持大椎，几个巨大的类似捣药碗似的东西里面似乎有惨叫之声传来，定睛细看，原来是囚犯被放进去，由巨人捣为肉泥，看了这许多惨状，你镇定了许多。“善恶到头终须报”，早知今日，何必当初啊。定了定神，你毅然地走向车崩狱。');
        $this->set('exits', array("up" => "death/moai",
            'down' => 'death/chebeng'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -180);

        parent::setup_room();
    }
}
