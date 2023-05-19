<?php
/**
*  师傅定义
*
*/

namespace std;

class master extends char
{
    function __construct($user = null) 
    {
        parent::__construct();
    }

    public function recruit_apprentice($me)
    {
        if ($me->is_apprentice_of($this))
            return false;
        if ($this->query("family") == null)
            return false;
	    if (!$name = $this->query("student_title"))
	        $name = "弟子";
	    $my_family = $this->query('family');
	    $family["master_id"] = $this->query("id");
	    $family["master_name"] = $this->query("name");
	    $family["family_name"] = $my_family["family_name"];
	    $family["generation"] = $my_family["generation"] + 1;
	    $family["enter_time"] = time();
	    $me->set("family", $family);
        if ($class = $this->query('class'))
	        $me->set("class", $class);
	    $this->assign_apprentice($me, $name, 0);
    }

    private function assign_apprentice($me, $title, $privs)
    {
		if ($this->query("family") == null)
            return false;
        $family = $me->query('family');
	    $family["title"] = $title;
	    $family["privs"] = $privs;

        global $CHINESE_D;
	    if ($me->is_player() || $me->query("title") == null) {
		    if ($family["generation"] == 1)
			    $me->set("title", $family["family_name"] . $family["title"]);
		    else
			    $me->set("title", $family["family_name"] . '第' . $CHINESE_D->chinese_number($family["generation"]) . '代' . $family["title"]);
        }
    }
}
