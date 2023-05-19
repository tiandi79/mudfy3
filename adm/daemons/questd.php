<?php
/**
*  任务分配
*
*/
namespace adm\daemons;

class questd
{
    public $quests;
    function __construct()
    {
    }

    public function query_quest($tag)
    {
        if (isset($this->quests[$tag])) {
            return $this->give_quest($this->quests[$tag]);
        } else {
            $this->quests[$tag] = require_once(ROOT_DIR . 'quest/qlist' . $tag . '.php');
            return $this->give_quest($this->quests[$tag]);
        }
    }

    private function give_quest($quests_list)
    {
        return $quests_list[rand(0, count($quests_list) - 1)];
    }
}

