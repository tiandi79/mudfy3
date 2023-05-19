<?php
/**
*   旧书
*
*/
namespace d\fy\npc\obj;

use std\obj;

class book extends obj
{
    public $names = array("「嘉德文选」", "「九韬」", "「太公辩」", "「梁父文集」",
                "「说律」", "「古文志」", "「乡书」", "「佾风斋诗集」",
                "「寒士列传」", "「水龙图注」");
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'book');
        $this->set('name', $this->names[rand(0, count($this->names) - 1)]);
        $this->set('long', '这是时下读书人常看的书籍。');
        $this->set('unit', '本');
        $this->set('value', 100);
        $this->set("material", "paper");
        $this->set('skill', array('name' => 'literate', 'exp_required' => 0, 'sen_cost' => 40, 'difficulty' => 30, 'max_skill' =>50));
        $this->set_weight(1);
    }
}
