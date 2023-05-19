<?php
/**
*  在线统计
*
*/
namespace adm\daemons;

class whod
{
    function __construct() 
    {
    }

    public function local_whos($ob, $para = null)
    {
        global $GAME, $CHINESE_D;
        $str = "◎ " . MUD_NAME;
        $list = $GAME->get_users();

        $ob->ssend($str . "——————————————————");
        foreach ($list as $k => $v) {
            switch($para) {
                case '-i':
                    $ob->ssend($list[$k]->body->id);
                    break;
                case '-l':
                    global $RANK_D;
                    $rank_msg = $RANK_D->query_rank($list[$k]->body);
                    $ob->ssend($rank_msg . ' ' . $list[$k]->body->name . '(' . $list[$k]->body->id . ')');
                    break;
                case '-f':
                    global $RANK_D;
                    $rank_msg = $RANK_D->query_rank($list[$k]->body);
                    $ob->ssend($rank_msg . ' ' . $list[$k]->body->title . ' ' . $list[$k]->body->name . '(' . $list[$k]->body->id . ')');
                    break;
                default:
                    $ob->ssend($list[$k]->body->name);
            }
        }
        $ob->ssend("—————————————————————————");
        $ob->ssend("共有" . $CHINESE_D->chinese_number(count($list)) . "位正在游戏中。");
    }
}
