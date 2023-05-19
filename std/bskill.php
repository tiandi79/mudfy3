<?php
/**
*   基本技能
*
*/
namespace std;

class bskill
{
    function __construct()
    {

    }

    public function perform_action($me, $pfm, $skill_type) {
        global $GAMESKILLS;
        if (!$perform = $GAMESKILLS->get_pfm($this, $pfm, $skill_type)) {
            if ($me->is_player())
                $me->get_conn()->send('你所用的外功里没有这个招式。');
            return false;
        }

        $target = attack::select_opponent($me);
        if (!$target) {
            return false;
        }

        if ($perform->perform($me, $target)) {
            return true;
        }
        else {
            return false;
        }
    }

    public function exert_action($me, $ext) {
        global $GAMESKILLS;
        if (!$exert = $GAMESKILLS->get_exert($this, $ext)) {
            $me->get_conn()->send('你所用的内功里没有这个招式。');
            return false;
        }

        $target = attack::select_opponent($me);
        if ($exert->exert($me, $target))
            return true;
        else {
            return false;
        }
    }

    public function cast_action($me, $cst) {
        global $GAMESKILLS;
        if (!$cast = $GAMESKILLS->get_cast($this, $cst)) {
            $me->get_conn()->send('你所用的咒术里没有这个招式。');
            return false;
        }

        $target = attack::select_opponent($me);
        if ($cast->cast($me, $target))
            return true;
        else {
            return false;
        }
    }

    public function query($key)
    {
        return $this->$key;
    }
}
