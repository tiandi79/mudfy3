<?php
/**
*  帮助
* 
*/

namespace cmds\usr;

class help
{
    function __construct() 
    {

    }

    public function do_cmd($ob, $cmds = null)
    {
        if (!isset($cmds)) {
            $msg = file_get_contents(HELP_DIR . 'topics.txt');
            $ob->ssend($msg);
        }
        else {
            $user = $ob->body;
            $usrfile = $user->get_cmd_file($cmds, 'usr');
            $stdfile = $user->get_cmd_file($cmds, 'std');
            $wizfile = $user->get_cmd_file($cmds, 'wiz');
            if (file_exists($usrfile) || file_exists($stdfile) || file_exists($wizfile)) {
                $final_cmd = strtoupper($cmds) . "_CMD";
                global $$final_cmd;
                $msg = $$final_cmd->help();
                $ob->ssend($msg);
                return true;
            }
            else {
                $ob->ssend("没有针对这项主题的说明文件。");
                return false;  
            }
        }
    }

    public function help() 
    {
        $ret = "指令格式：help <主题>这个指令提供你针对某一主题的详细说明文件，若是不指定主题，则提供你有关主题的文件。";
        return $ret;
    }
}
