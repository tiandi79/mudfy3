<?php
/**
*   南宫十一郎
*
*/
namespace d\fy\npc;

use std\msg;
use std\bankowner;

class nangong extends bankowner
{
    function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function init()
    {
        $this->set('name', '南宫十一郎');
        $this->set('id', 'shiyi');
        $this->set('age', 22);
        $this->set('gender', '男性');
        $this->set("title", "HIR钱庄大少NOR");
        $this->set('long', '中原南宫世家，家财万贯，产业不可胜数，南宫十一郎乃钱庄大少。');        
        $this->set("combat_exp", 1000000);
        $this->set("richness", 5000000);
	    $this->set("attitude", "friendly");
	    $this->set("per", 30);
	    $this->set("no_arrest", 1);
        $this->set("max_atman", 1000);         
        $this->set("atman", 1000);             
        $this->set("max_force", 1000);         
        $this->set("force", 1000);             
        $this->set("max_mana", 1000);          
        $this->set("mana", 1000);            
	    $this->set_skill("unarmed",200);
        $this->set_skill("dodge", 100);
        $this->set_skill("force", 100);
        $this->set_skill("celestrike", 100);
        $this->set_skill("celestial", 100);
        $this->set_skill("chaossteps", 100);

        $this->map_skill("force", "celestial");
        $this->map_skill("unarmed", "celestrike");
        $this->map_skill("dodge", "chaossteps");
        $this->add_money("gold", 10);
        $this->equip_object('d/fy/npc/obj/jinzhuang');
    }
}
