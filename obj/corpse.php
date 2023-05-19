<?php
/**
*  尸体
*
*/
namespace obj;

use std\obj;
use std\msg;

class corpse extends obj
{
    function __construct()
    {
        $this->name = '无名尸体';
        $this->id = 'corpse';
        $this->long = '这是一具无名尸体。';
        $this->unit = '具';
    }

    public function is_corpse()
    {
        return true;
    }

    public function decay($i = 0)
    {
        switch($i) {
            case 1:
                if ($this->query('gender' == '男性'))
                    $this->set('name', '腐烂的男尸');
                elseif ($this->query('gender' == '女性'))
                    $this->set('name', '腐烂的女尸');
                else
                    $this->set('name', '腐烂的尸体');
                $this->set('long', '这具尸体显然已经躺在这里有一段时间了，正散发著一股腐尸的味道。');
                $this->call_out(120, 'decay', 2);
                break;
            case 2:
                msg::message_text('vision', $this->query('name') . '被风吹乾了，变成一具骸骨。', $this);
                $this->set('name', '一具枯乾的骸骨');
                $this->set('id', 'skeleton');
                $this->set('long', '这副骸骨已经躺在这里很久了。');
                $this->call_out(60, 'decay', 3);
                break;
            default:
                msg::message_text('vision', '一阵风吹过，把' . $this->query('name') . '化成骨灰吹散了。', $this);
                $this->destruct();
                break;
        }
    }
}
