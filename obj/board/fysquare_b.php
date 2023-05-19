<?php
/**
*   盘龙摩天柱
*
*/
namespace obj\board;

use std\board;

class fysquare_b extends board
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'stone');
        $this->set('name', '盘龙摩天柱');
        $this->set('long', '这是一条石柱，石柱上刻着一条九头龙。龙首向四面伸展，宏伟壮观。<br>请用read命令来阅读留言。');
        $this->set("capacity", 49);
        $this->set('board_id', 'fysquare_b');
        $this->init_board();
    }
}
