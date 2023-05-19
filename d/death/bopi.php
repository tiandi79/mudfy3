<?php
/**
*  剥皮狱
*
*/
namespace d\death;

use std\room;

class bopi extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '剥皮狱');
        $this->set('long', '几只大钩子悬于半空，上悬数人，几个牛头，马面以极为熟练的手法在人犯头顶开口，然后灌入水银，旋即剥下一张完整的人皮，令人做呕，地府之酷刑，一至于斯，一牛头鬼似乎看穿了你的心思，淡然说道“十恶不赦之徒，非此不能降其心啊，地府之中，虽酷但自有公道”。话虽如此，你还是忍耐不住，向下面的磨捱狱走去。');
        $this->set('exits', array("up" => "death/bashe",
            'down' => 'death/moai'));

        $this->set('coor/x', -1020);
        $this->set('coor/y', -70);
        $this->set('coor/z', -160);

        parent::setup_room();
    }
}
