<?php
/**
*  风云广场
*
*/
namespace d\fy;

use std\room;

class fysquare extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '风云广场');
        $this->set('long', '风云城的风街和云路在这里呈十字交叉，宽阔的街道在这里形成一个巨大的广场。广场的中央是方园约十丈的水池，池中有尾尾金鱼在悠闲的漫游。金色的鱼鳞与碧绿的浮萍相互辉映，赏心悦目。池水的中央是一条石柱，石柱上刻着一条九头龙。龙首向四面伸展，宏伟壮观。每当雨天，潺潺雨珠涓涓涌出龙首，如情人之泪，落断情肠。');
        $this->set('exits', array("south" => "fy/swind1",
                             "north" => "fy/nwind1",
                             "east" => "fy/ecloud1",
                             "west" => "fy/wcloud1"));
        $this->objects = array("/obj/board/fysquare_b" => 1,
            "fy/npc/half_god" => 1);

        $this->set('coor/x', 0);
        $this->set('coor/y', 0);
        $this->set('coor/z', 0);
        $this->set('outdoor', 'fengyun');
        $this->set('no_fight', 1);
        $this->set('no_magic', 1);
        $this->set('NONPC', 1);
        $this->set('resource/water', 1);
        $this->set("liquid", array("type" => "alcohol", "name" => "碧绿的水", "drunk_apply" => 3));

        parent::setup_room();
    }

    public function do_fillwater($ob, $arg)
    {
        if (null == $arg) {
            $ob->ssend('你要往什么东西里灌水？');
            return true;
        }

        $me = $ob->body;

        if ($arg == 'skin' || $arg == 'wineskin') {
            $objs = $me->all_inventory();
            foreach ($objs as $k => $v) {
                if ($liquid = $v->query('liquid')) {
                    if ($liquid['type'] == 'water' || $liquid['type'] == 'alcohol') {
                        $v->set('liquid', array('type' => 'water', 'name' => '清水', 'remaining' => 15, 'drunk_apply' => 6));
                        $ob->ssend('你从水池里装满了清水！');
                        return true;
                    }
                }
            }
            $ob->ssend('你没有装水的东西啊....');
        } else {
            $ob->ssend('你要往什么东西里灌水？');
        }
        return true;
    }
}
