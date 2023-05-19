<?php
/**
*  地藏殿
*
*/
namespace d\death;

use std\room;

class dizang extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '地藏殿');
        $this->set('long', '在这地府之中，居然有一处仙宫，实在难以置信，这是幽冥教主地藏菩萨的寝宫，相传地藏原为朝鲜王子，修练得道于九华，因其公正无私，故掌万物轮回，座下神兽谛听，善听人言辨真伪。但凡阎王有难决之案，皆送至此处，由地藏菩萨处置，菩萨便以那无边慈航，广渡众生。');
        $this->set('exits', array("southup" => "death/beiyin"));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -40);
        $this->set('coor/z', -100);

        parent::setup_room();
    }
}
