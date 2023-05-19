<?php
/**
*
*
*/
namespace adm\daemons;

class chard
{
    function __construct()
    {

    }

    public function setup_char($user = null)
    {
        if (!isset($user->race))
            $user->race = '人类';

        switch($user->race) {
            case '人类':
                global $HUMAN_RACE;
                $HUMAN_RACE->setup_human($user);
                break;
            case '妖魔':

                break;
            case '妖魔':

                break;
        }

        if (!isset($user->gin))
            $user->gin = $user->max_gin;
        if (!isset($user->kee))
            $user->kee = $user->max_kee;
        if (!isset($user->sen))
            $user->sen = $user->max_sen;

        if (!isset($user->eff_gin))
            $user->eff_gin = $user->max_gin;
        if (!isset($user->eff_kee))
            $user->eff_kee = $user->max_kee;
        if (!isset($user->eff_sen))
            $user->eff_sen = $user->max_sen;

        if (!isset($user->atman_factor))
            $user->atman_factor = 0;
        if (!isset($user->force_factor))
            $user->force_factor = 0;
        if (!isset($user->mana_factor))
            $user->mana_factor = 0;


        if (null == $user->query_max_encumbrance())
            $user->set_max_encumbrance($user->str * 20000);

        $user->set_temp('apply/damage', 0);
        $user->set_temp('apply/armor', 0);
        $user->set_temp('apply/dodge', 0);
        $user->set_temp('apply/move', 0);

        $user->set('combat_exp', 2000);

        //$user->reset_action();
    }

    public function make_corpse($victim, $killer)
    {
        if ($victim->is_ghost()) {
            $inv = $victim->all_inventory();
            if (null == $inv)
                return null;
            foreach ($inv as $v) {
                $v->owner_is_killed($killer);
                $v->move($victim->get_env());
            }
            return null;
        }

        if ($victim->is_zombie()) {
            $inv = $victim->all_inventory();
            if (null == $inv)
                return null;
            foreach ($inv as $v) {
                $v->owner_is_killed($killer);
                $v->move($victim->get_env());
            }
            msg::message_text('vision', $victim-name . '缓缓地倒了下来，化为一滩血水。', $victim);
            return null;
        }

        global $OBJECT;
        $corpse = $OBJECT->create_objects('/obj/corpse');
        $corpse->set('name', $victim->name . "的尸体");
        if ($victim->is_player())
            $corpse->set("long", $victim->name ."已经死了，只剩下一具尸体静静地躺在这里。");
        else
            $corpse->set("long", $victim->query('long') . "然而，" . $this->gender_pronoun($victim->query("gender")) . "已经死了，只剩下一具尸体静静地躺在这里。");
        $corpse->set("age", $victim->query("age"));
        $corpse->set("gender", $victim->query("gender"));
        $corpse->set("victim_name", $victim->name);
        $corpse->set_weight($victim->query_weight() * ($victim->is_player() ? 100 : 1));
        $corpse->set_max_encumbrance($victim->query_max_encumbrance());
        $corpse->move($victim->get_env());
        $corpse->call_out(120, 'decay', 1);

        $inv = $victim->all_inventory();
        
        if ($inv != null) {
            foreach ($inv as $v) {
                $v->owner_is_killed($killer);
                if (null == $v->query('no_drop')) {
                    $v->move($corpse);            
                }
            }
        }
        return $corpse;
    }

    private function gender_pronoun($gender)
    {
        if ($gender == '男性')
            return '他';
        elseif ($gender == '女性')
            return '她';
        else
            return '它';
    }
}
