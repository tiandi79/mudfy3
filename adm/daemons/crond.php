<?php
/**
*  crond
*
*/
namespace adm\daemons;

class crond
{
    function __construct()
    {

    }

    public function run($arg = null)
    {
        global $GAME, $TASK_D;
        /* 重新分布TASK */
        if ((time() - $GAME->game_start) % TASK_RESPREAD == 0) {
            foreach ($GAME->users as $ob) {
                $ob->ssend('HIR重新分布所有使命。。。NOR');
                if (DEBUG_MODE)
                    echo date("Y/m/d H:i:s") . " Respread task now.\n";
            }
            $TASK_D->init_dynamic_quest(1);
            foreach ($GAME->users as $ob) {
                $ob->ssend('HIG。。。所有使命分布完毕NOR<br>');
                if (DEBUG_MODE)
                    echo date("Y/m/d H:i:s") . " Finish respred task.\n";
            }
        } elseif ((time() - $GAME->game_start) % TASK_REFRESH == 0) {
            $TASK_D->init_dynamic_quest();
            if (DEBUG_MODE)
                echo date("Y/m/d H:i:s") . " Refresh task now.\n";
        }
    }
}
