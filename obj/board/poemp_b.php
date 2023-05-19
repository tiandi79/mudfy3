<?php
/**
*   盘龙摩天柱
*
*/
namespace obj\board;

use std\board;

class poemp_b extends board
{
    function __construct()
    {
        parent::__construct();
        $this->set('id', 'board');
        $this->set('name', '风云雅兴集');
        $this->set('long', '这是一个供风云人物雅兴大发时所用。');
        $this->set("capacity", 49);
        $this->set('board_id', 'poemp_b');
        $this->init_board();
    }
}
