<?php
/**
*  秤杆狱
*
*/
namespace d\death;

use std\room;

class banggan extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '秤杆狱');
        $this->set('long', '此狱乃是公平所在，大凡罪犯最怕正义，用公平和正义去惩罚他们，才是最让他们胆寒的，所以地藏特地设此一狱，无刑无罚，但只教满腹正
义之人讲书论课，宣天下至理，直至感化为止。到此便再无刑狱。往下便是出口，直通枉死城。');
        $this->set('exits', array("up" => "death/abi",
            'down' => 'death/wangsi'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -280);

        parent::setup_room();
    }
}
