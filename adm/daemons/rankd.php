<?php
/**
*  称谓称呼
*
*/
namespace adm\daemons;

class rankd
{
    function __construct()
    {

    }

    public function query_rank($user)
    {
        if ($user->is_ghost())
            return 'BLU【鬼魂】NOR';

        return '';
    }

    public function query_rude($user)
    {
        if ($user->query('rank_info/rude') !== null)
            return $user->query('rank_info/rude');

        $age = $user->query('age');
        switch($user->query('gender')) {
            case '女性':
                if ($user->query('class') != null && $user->query('class') == 'bonze') {
                    return '贼尼';
                    break;
                }
                elseif ($user->query('class') != null && $user->query('class') == 'taoist') {
                    return '妖女';
                    break;
                }
                else {
                    if ($age < 30)
                        return '小贱人';
                    else
                        return '死老太婆';
                    break;
                }
            case '男性':
                if ($user->query('class') != null && $user->query('class') == 'bonze') {
                    if ($age < 50)
                        return '死秃驴';
                    else
                        return '老秃驴';
                    break;
                } elseif ($user->query('class') != null && $user->query('class') == 'taoist') {
                    return '死牛鼻子';
                    break;
                }
                else {
                    if ($age < 20)
                        return '小王八蛋';
                    elseif ($age < 50)
                        return '臭贼';
                    else
                        return '老匹夫';
                    break;
                }
        }
    }

    public function query_self($user)
    {
        if ($user->query('rank_info/self') !== null)
            return $user->query('rank_info/self');

        $age = $user->query('age');
        switch($user->query('gender')) {
            case '女性':
                if ($user->query('class') != null && $user->query('class') == 'bonze') {
                    if ($age < 50)
                        return '贫尼';
                    else
                        return '老尼';
                    break;
                }
                else {
                    if ($age < 30)
                        return '小女子';
                    else
                        return '妾身';
                    break;
                }
            case '男性':
                if ($user->query('class') != null && $user->query('class') == 'bonze') {
                    if ($age < 50)
                        return '贫僧';
                    else
                        return '老衲';
                    break;
                }
                else {
                    if ($age < 30)
                        return '在下';
                    else
                        return '老头子';
                    break;
                }
        }
    }

    public function query_respect($target)
    {
        if ($target->query('rank_info/respect') !== null)
            return $target->query('rank_info/respect');

        $age = $target->query('age');
        switch($target->query('gender')) {
            case '女性':
                if ($target->query('class') != null && $target->query('class') == 'bonze') {
                    if ($age < 18)
                        return '小师太';
                    else
                        return '师太';
                    break;   
                } 
                elseif ($target->query('class') != null && $target->query('class') == 'taoist') {
                    if ($age < 18)
                        return '小仙姑';
                    else
                        return '仙姑';
                    break;
                }
                else {
                    if ($age < 18)
                        return '小姑娘';
                    elseif ($age < 50)
                        return '姑娘';
                    else
                        return '婆婆';
                    break;
                }
            case '男性':
                if ($target->query('class') != null && $target->query('class') == 'bonze') {
                    if ($age < 18)
                        return '小师傅';
                    else
                        return '大师';
                    break;
                }
                elseif ($target->query('class') != null && $target->query('class') == 'taoist') {
                    if ($age < 18)
                        return '道兄';
                    else
                        return '道长';
                    break;
                }
                elseif ($target->query('class') != null && in_array($target->query('class'), array('fighter', 'swordman'))) {
                    if ($age < 18)
                        return '小老弟';
                    elseif ($age < 50)
                        return '壮士';
                    else
                        return '老前辈';
                    break;
                }
                else {
                    if ($age < 18)
                        return '小兄弟';
                    elseif ($age < 50)
                        return '壮士';
                    else
                        return '老爷子';
                    break;
                }
        }
    }
}
