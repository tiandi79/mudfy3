<?php
/**
*  知府书房
*
*/
namespace d\fy;

use std\msg;
use std\room;

class shufang extends room
{
    function __construct($oid = null)
    {
        parent::__construct($oid);
        $this->init();
    }

    public function init()
    {
        $this->set('name', '知府书房');
        $this->set('long', '这书室庭户虚敞，正中挂一幅名人山水。供一个古铜香炉，炉里香烟飘渺。左边设一张湘妃竹榻，右边架上堆满若干图书。沿窗一只几上，摆列文房四宝。窗外庭中种植许多花木，铺设得十分清雅，凡朝廷命官都可在这发号令（ａｒｒｅｓｔ）。');
        $this->set('exits', array("west" => "fy/govern"));
        $this->set('objects', array('d/fy/npc/governor' => 1));
        $this->set('coor/x', -19);
        $this->set('coor/y', -10);
        $this->set('coor/z', 0);

        parent::setup_room();
    }

    public function do_arrest($ob, $arg)
    {
        if (null == $arg) {
            $ob->ssend('你要下令缉拿谁？');
            return true;
        }
        $me = $ob->body;
        if ($me->query('class') != 'official') {
            $ob->ssend('你不是朝廷官员，不可缉拿疑犯！');
            return true;
        }

        if ($me->query('sen') < 50) {
            $ob->ssend('你的心神不够！');
            return true;
        }
        $me->add('sen', -50);
        global $OBJECT;
        if (!$target = $OBJECT->find_living($arg)) {
            $ob->ssend('找不到你想要的疑犯！');
            return true;
        }

        if ($target->is_player() || $target->query('no_arrest') != null) {
            $ob->ssend('找不到你想要的疑犯！');
            return true;
        }

        msg::message('vision', '$N大声下令道：来人那．．把$n给我拿来！！', $me, $target);
        $exp = $target->query("combat_exp");
	    $stra = $me->query_skill("strategy", 1);
	    $leader = $me->query_skill("leadership", 1);
	    $factor = $stra * $stra * $leader * $leader;
	    $factor = ($factor + $me->query("combat_exp") - 2000 ) / 1000;			
	    if (rand(0, $factor) <= $exp) {
            $ob->ssend('以你现在的能力，还不足以缉拿' . $target->query('name') . '!');
	        return true;
        }

        $this->call_out(5, "gethim", array($me, $target));
        return true;
    }

    public function gethim($me, $target)
    {
        if (!$target || !$me ) 
            return false;
	    if ($me->get_env() == $this) {
            msg::message('vision', '$N一句话不说，匆匆忙忙地离开了。', $target);
            $target->move($this);
            msg::message('vision', '$N被官兵押了进来。', $target);
        }
        if ($me) {
            $me->kill_ob($target);
            $target->kill_ob($me);
        }
        return true;
	}

    public function valid_leave($me, $dir)
    {
        if ($me->is_fighting()) {
            $ob->ssend('你现在不可离开！');
	        return false;
        }
        else 
            return true;
    }
}
