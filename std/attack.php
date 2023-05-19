<?php
/**
*
*  
*/
namespace std;

class attack
{
    function __construct()
    {

    }

    public static function attack_init($me)
    {
        $opponent = self::select_opponent($me);
        if ($opponent == null) {
            $me->set_temp('in_fighting', null);
            return false;
        }

        if (!$opponent->is_character()) {
            return false;
        }
        global $COMBAT_D;
        $COMBAT_D->fight($me, $opponent);
    }

    public static function select_opponent($me)
    {
        if (null == $me->query_temp('enemy')) {
            return false;
        }

        $enemys = $me->query_temp('enemy');

        /* 清除不在同一场景的敌人对*/
        foreach ($enemys as $k => $v) {
            if (!$me->is_environment($v->query('id'))) {
                unset($enemys[$k]);
            }
        }
        if (count($enemys) == 0) {
            return null;
        }

        $i = rand(0, count($enemys)) - 1;
        if ($i < 0 ) 
            $i = 0;
        return $enemys[$i];
    }
}
