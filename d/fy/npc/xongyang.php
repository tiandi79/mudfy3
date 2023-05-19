<?php
/**
*   郭嵩阳
*
*/
namespace d\fy\npc;

use std\msg;
use std\char;

class xongyang extends char
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '郭嵩阳');
        $this->set('id', 'guo');
        $this->set("age", 32);
        $this->set('title', '嵩阳铁剑');
        $this->set("gender", "男性" );
        $this->set('long', '这是一位兵器谱上有名的高手，但他现在没剑．．．');
        $this->set("combat_exp", 50000);
        $this->set("attitude", "friendly");
        $this->set_skill("sword", 100);
    }    

    public function recognize_apprentice($me)
    {
        if (!$me->get_mark("guo")) {
            $me->get_conn()->ssend('郭嵩阳道：我连剑都没有....');
            return false;
        }
        return true;
    }

    public function accept_object($me, $obj)
    {
        if ($me->query("id") == "guosword") {
            $me->set_mark('guo', 1);
            $me->get_conn()->ssend('郭嵩阳说道：好！好！好！太好了！你没拜我为师，别的不能教你，但几手基本剑法还是可以的！');
            if (!$me->get_story('郭嵩阳')) {
                $me->set_story('郭嵩阳');
                $me->add("score", 400);
            }
            return true;
        }
	    return false;
    }
}
