<?php
/**
*  询问
*
*/
namespace cmds\std;

use std\msg;

class ask
{
    public $msg_dunno;
    function __construct()
    {   
        $this->msg_dunno = array('$n根本不想回答你的问题。', 
            '$n睁大眼睛望著$N：这么简单的问题都要问吗？', 
            '$n耸了耸肩，很惋惜地说：你真是不可救药！',
            '$n说道：嗯....这问题你可以问问自己吗！',
            '$n说道：对不起，太多人问我同样的问题了！');
    }

    public function do_cmd($ob, $target = null, $about = 'about', $topic = null)
    {
        $me = $ob->body;

        if ($target == null || $about != 'about' || $topic == null) {
            $ob->ssend('指令格式: ask <某人> about <某事>');
            return false;
        }
         
        if (!$who = $me->is_environment($target)) {
            $ob->ssend('这里没有这个人。');
            return false;
        }

        if (!$who->is_character()) {
            msg::message('$N对著$n自言自语....', $me, $who);
            return false;
        }

        if (!$who->query('can_speak') ) {
            msg::message('$N向$n打听有关『' . $topic . '』的消息，但是$p显然听不懂人话。', $me, $who);
            return false;
        }

        msg::message('vision', '$N向$n打听有关『' . $topic . '』的消息。', $me, $who);

        if (!$who->living()) {
            msg::message('但是很显然的，$n现在的状况没有办法给$N任何答覆。', $me, $who);
            return false;
        }
            
        if ($who->is_player())
            return true;
        else {
            $msgs = $who->query('inquiry');
            if (isset($msgs)) {
                foreach ($msgs as $k => $v) {
                    if ($k == $topic) {
                        if (substr($v, 0, 1) == ':') {
                            $act = substr($v, 1);
                            if (method_exists($who, $act))
                                $who->$act($me);
                        }
                        else {
                            msg::message_text('say', $v, $who);
                        }
                        return true;
                    }
                }
            }
            msg::message('vision', $this->msg_dunno[rand(0, count($this->msg_dunno) - 1)], $me, $who);
            return false;
        }
    }

    public function help() 
    {
        $ret = "指令格式: ask <某人> about <某事><br>这个指令在解谜时很重要, 通常必须藉由此一指令才能获得进一步的资讯。";
        return $ret;
    }
}
