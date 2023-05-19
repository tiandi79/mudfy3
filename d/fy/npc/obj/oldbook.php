<?php
/**
*   旧书
*
*/
namespace d\fy\npc\obj;

use std\obj;

class oldbook extends obj
{
    function __construct()
    {
        parent::__construct();

        $this->set('id', 'book');
        $this->set('name', '旧书');
        $this->set('long', '这本旧书的纸张都已经泛黄了，上面居然记载着武道禅宗：嫁衣神功。传说中是一门极为厉害的内功，但至今为止，却无人能够练成。尤其是『为人作嫁』〔jiayi〕，只有施展出来，才知道有什么用处。');
        $this->set('unit', '本');
        $this->set('value', 70);
        $this->set("material", "paper");
        $this->set('skill', array('name' => 'jiayiforce', 'exp_required' => 0, 'sen_cost' => 60, 'difficulty' => 50, 'max_skill' =>45));
        $this->set_weight(1);
    }
}
