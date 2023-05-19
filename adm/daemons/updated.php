<?php
/**
*  刷新
*
*/
namespace adm\daemons;

class updated
{
    function __construct()
    {

    }

    public function check_user($user)
    {
        if (!isset($user->eff_gin))
            $user->eff_gin = $user->max_gin;
        if (!isset($user->eff_kee))
            $user->eff_kee = $user->max_kee;
        if (!isset($user->eff_sen))
            $user->eff_sen = $user->max_sen;

        if ($user->eff_gin > $user->max_gin)
            $user->eff_gin = $user->max_gin;
        if ($user->eff_kee > $user->max_kee)
            $user->eff_kee = $user->max_kee;
        if ($user->eff_sen > $user->max_sen)
            $user->eff_sen = $user->max_sen;

        if ($user->gin > $user->eff_gin)
            $user->gin = $user->eff_gin;
        if ($user->kee > $user->eff_kee)
            $user->kee = $user->eff_kee;
        if ($user->sen > $user->eff_sen)
            $user->sen = $user->eff_sen;
    }
}
