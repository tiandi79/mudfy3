<?php
/**
*   game 类全局对象
*
*/
namespace libs;

use \std\msg;
use \obj\login;
use \Workerman\Lib\Timer;

class game
{
    public $game_start;   
    public $ppl_cnt;
    public $login_cnt;
    public $wiz_cnt;
    public $uid;
    public $oid;
    public $users;
    public $timer_debug = false;
    public $last_reset_time;
    public $last_cleanup_time;

    function __construct()
    {
        $this->uid = 1;
        $this->oid = 1;
        $this->game_start = time();
        $this->ppl_cnt = 0;
        $this->login_cnt = 0;
        $this->wiz_cnt = 0;
        $this->users = array();
        $this->status = 0;  //0是开放，1是维护关闭
    }

    public function shutdown($me, $i)
    {
        $users = $this->users;
        global $CHINESE_D;
        if ($i > 0) {
            msg::channel('sys', MUD_NAME . '将在' . $CHINESE_D->chinese_number($i) . '分钟后关闭，请玩家尽快退出，以免存档受损！！！', $me);
            $i--;
            Timer::add(60, array($this, 'shutdown'), array($me, $i), false);
        } else {
            msg::channel('sys', MUD_NAME . '关闭，系统进入无尽的虚空中。。。', $me);
            foreach ($users as $ob) {
                $ob->body->save();
                $ob->destroy();
            }
        }
    }

    public function onWorkerStart($worker)
    {
        global $NATURE_D;
        $NATURE_D->init_day_phase();
        $this->last_reset_time = time();
        $this->last_release_time = time();

        Timer::add(1, function() use ($worker){
            global $CRON_D;
            $CRON_D->run();
            foreach($worker->connections as $connection) {                
                /* 只作用在游戏中 */
                if ($connection->status == 'in_game') {
                    $time_now = time();
                    /* 如果刚进入的用户，设置最后更新时间 */
                    if (empty($connection->lasttime)) {
                        $connection->lasttime = $time_now;
                        continue;
                    }

                    /* 发呆超过15分钟，则踢出用户 */
                    $user = $connection->body;
                    if ($time_now - $connection->lasttime > KICKOUT_TIME) {     
                        global $CHINESE_D;                     
                        $user->do_cmd($connection, 'drop all');
                        $user->save();
                        if (isset($user->place)) {
                            $user->place->unset_carry($user);
                        }
                        $this->remove_ppl($connection);    
                        $connection->ssend('对不起，您已经发呆超过' . $CHINESE_D->chinese_number(intval(KICKOUT_TIME/60)) . '分钟了，请下次再来。');
                        msg::message_text('vision','一阵风吹来，将发呆中的' . $user->query('name') . '化为一堆飞灰，消失了。', $user);
                        $connection->destroy();
                    }
                    elseif ($user->have_heart) {
                        $user->heart_beat();
                    }               
                }                
            }
            
            global $OBJECT;
            /* 处理npc心跳 */
            foreach ($OBJECT->_objs as $v) {   
                if (isset($v->is_character) && !$v->is_player() && $v->have_heart)
                    $v->heart_beat();
            }
            /* 处理场景重置 */
            if ($this->last_reset_time + ROOM_RESET_RATIO < time()) {
                echo date("Y/m/d H:i:s") . " Update room now.\n";
                foreach ($OBJECT->_rooms as $v) {
                    if (isset($v->type) && $v->type == 'room') {
                        $OBJECT->update_room($v->id);
                    }
                }
                $this->last_reset_time = time();
            }
        });
    }

    public function onConnect($ob)
    {
        $welcome = file_get_contents(ROOT_DIR . 'adm/etc/welcome');
        $ob->send($welcome);
        if ($this->status > 0) {
            $ob->ssend(MUD_NAME . '目前正在关闭维护中，请稍后尝试登陆。');
            return false;
        }
        $ob->status = 'connect_init';
        $login_ob = new login($ob);
        //echo "\ncreate new connect id is " . $ob->id;
    }

    public function onMessage($ob, $data)
    {
        /* 如果有登录计时器，则输入后重置 */
        if (isset($ob->login_timer)) {
            if (Timer::del($ob->login_timer)) {
                if ($this->timer_debug)
                    echo "\nnow timer = ". $ob->login_timer . ' deleted.';
                $ob->login_timer = null;
                $login_ob = new login($ob, false);              
            }
        }

        if (!$this->check_input($data)) {
            $ob->ssend('输入含有非法字符！');
            return false;
        }

        global $LOGIN_D;
        switch($ob->status) {  
            /* 输入英文id */
            case 'input_id':
                if ($LOGIN_D->input_id($ob, $data)) {
                    $LOGIN_D->check_is_exist($ob, $data);
                }
                else
                    return false;
                break;
            /* 输入旧密码 */
            case 'get_password':
                if ($LOGIN_D->get_password($ob, $data)) {
                    $LOGIN_D->password_correct($ob);
                }
                else
                    return false;
                break;
            /* 输入中文名称 */
            case 'input_name':
                if ($LOGIN_D->get_name($ob, $data)) {
                }
                else
                    return false;
                break;
            /* 确认新建用户 */
            case 'confirm_new_player':
                if ($LOGIN_D->confirm_new_player($ob, $data)) {
                    $LOGIN_D->create_new_user($ob);
                }
                else
                    return false;
                break;
            /* 确认是否要踢出用户 */
            case 'confirm_kick_player':
                if ($LOGIN_D->confirm_kick_player($ob, $data)) {
                    $LOGIN_D->kick_player($ob);
                }
                else
                    return false;
                break;
            /* 确认中文名称 */
            case 'confirm_cname':
                if ($LOGIN_D->confirm_cname($ob, $data)) {
                    $LOGIN_D->random_cname_finish($ob);
                }
                else
                    $LOGIN_D->random_cname_again($ob);
                break;
            /* 确认密码 */
            case 'confirm_first_password':
                if ($LOGIN_D->confirm_first_password($ob, $data)) {
                    $LOGIN_D->input_repeat_password($ob);
                }
                else
                    return false;
                break;
            /* 二次确认密码 */
            case 'repeat_password':
                if ($LOGIN_D->confirm_repeat_password($ob, $data)) {
                    $LOGIN_D->choice_sex($ob);
                }
                else
                    return false;
                break;
            /* 选择性别 */
            case 'confirm_sex':
                if ($LOGIN_D->confirm_sex($ob, $data)) {
                    $LOGIN_D->set_sex($ob);
                }
                else
                    return false;
                break;
            /* 选择种族 */
            case 'choice_national':
                if ($LOGIN_D->confirm_national($ob, $data)) {
                    $LOGIN_D->readycreate($ob);
                }
                else 
                    return false;
                break;
            /* 游戏中 */
            case 'in_game':
                $ob->lasttime = time();
                $user = $ob->body;
                if ($user->query_temp('disable_inputs') != null) {
                    $ob->ssend('什么?');
                    return false;
                }
                if ($user->query_temp('input_board')) {
                    if ($data == '~q') {
                        $user->set_temp('input_board', null);
                        $user->set_temp("block_msg/all", null);
                        $ob->ssend('退出编辑模式。');
                        return false;
                    }
                    elseif ($data == '.') {
                        $user->set_temp("block_msg/all", null);
                        $user->do_cmd($ob, 'postdone');
                        return false;
                    } else {
                        $post = $user->query_temp('input_board');
                        $post['content'] .= "<br>" . $data;
                        $user->set_temp('input_board', $post);
                        return false;
                    }
                }
                $data = $this->convert_cmds($data);
                if (!$user->do_cmd($ob, $data)) {
                    // 向客户端发送无效命令 $data
                    $ob->ssend('什么?');
                    return false;
                }
                break;
            default:
                $ob->send('您当前状态无法执行这条命令。' . $data);
                return false;
        } 
    }

    private function check_input($cmd)
    {
        $arr = array('<','>','?','*','(',')','/','\\');
        //$arr2 = array('<','?','*','(',')','\\');

        $flag = 0;
        $len = strlen($cmd);
        for($i = 0;$i < $len;$i++) {
            if ($flag == 0) {
                if (in_array($cmd[$i], $arr))
                    return false;
                elseif ($cmd[$i] == ' ')
                    $flag = 1;
            }
            //elseif (in_array($cmd[$i], $arr2))
            //    return false;
        }
        return true;
    }

    private function convert_cmds($cmd)
    {
        $full_cmd = '';
        $cmds = explode(" ", $cmd);
        switch($cmds[0]) {
            case 'l':
                $full_cmd = trim('look ' . (isset($cmds[1]) ? $cmds[1] : ''));
                break;
            case 'i':
                $full_cmd = trim('inventory ' . (isset($cmds[1]) ? $cmds[1] : ''));
                break;
            case 'west':
            case 'w':
                $full_cmd = 'go west';
                break;
            case 'east':
            case 'e':
                $full_cmd = 'go east';
                break;
            case 'north':
            case 'n':
                $full_cmd = 'go north';
                break;
            case 'south':
            case 's':
                $full_cmd = 'go south';
                break;
            case 'eastup':
            case 'eu':
                $full_cmd = 'go eastup';
                break;
            case 'southup':
            case 'su':
                $full_cmd = 'go southup';
                break;
            case 'westup':
            case 'wu':
                $full_cmd = 'go westup';
                break;
            case 'northup':
            case 'nu':
                $full_cmd = 'go northup';
                break;
            case 'eastdown':
            case 'ed':
                $full_cmd = 'go eastdown';
                break;
            case 'southdown':
            case 'sd':
                $full_cmd = 'go southdown';
                break;
            case 'westdown':
            case 'wd':
                $full_cmd = 'go westdown';
                break;
            case 'northdown':
            case 'nd':
                $full_cmd = 'go northdown';
                break;
            case 'northeast':
            case 'ne':
                $full_cmd = 'go northeast';
                break;
            case 'northwest':
            case 'nw':
                $full_cmd = 'go northwest';
                break;
            case 'southeast':
            case 'se':
                $full_cmd = 'go southeast';
                break;
            case 'southwest':
            case 'sw':
                $full_cmd = 'go southwest';
                break;
            case 'u':
                $full_cmd = 'go up';
                break;
            case 'eu':
                $full_cmd = 'go eastup';
                break;
            case 'wu':
                $full_cmd = 'go westup';
                break;
            case 'nu':
                $full_cmd = 'go northup';
                break;
            case 'su':
                $full_cmd = 'go southup';
                break;
            case 'd':
                $full_cmd = 'go down';
                break;
            case 'ed':
                $full_cmd = 'go eastdown';
                break;
            case 'wd':
                $full_cmd = 'go westdown';
                break;
            case 'nd':
                $full_cmd = 'go northdown';
                break;
            case 'sd':
                $full_cmd = 'go southdown';
                break;
            default:
                $full_cmd = $cmd;
        }
        return $full_cmd;
    }

    public function add_ppl($ob)
    {
        
        if ($this->add_user($this->uid, $this->oid, $ob)) {
            $this->ppl_cnt++;
            $this->uid++;
            $this->oid++;
        }
        return $this->ppl_cnt;
    }

    public function get_ppl_cnt()
    {
        return $this->ppl_cnt;
    }

    public function remove_ppl($ob)
    {       
        if ($this->remove_user($ob)) {
            $this->ppl_cnt--;
            if ($this->ppl_cnt < 0)
                $this->ppl_cnt = 0;
        }        
        return $this->ppl_cnt;
    }

    public function add_login()
    {
        $this->login_cnt++;
        return $this->login_cnt;
    }

    public function remove_login()
    {
        $this->login_cnt--;
        if ($this->login_cnt < 0)
            $this->login_cnt = 0;
        return $this->login_cnt;
    }

    public function get_login_cnt()
    {
        return $this->login_cnt;
    }

    public function add_wiz()
    {
        $this->wiz_cnt++;
        return $this->wiz_cnt;
    }

    public function remove_wiz()
    {
        $this->wiz_cnt--;
        if ($this->wiz_cnt < 0)
            $this->wiz_cnt = 0;
        return $this->wiz_cnt;
    }

    public function get_wiz_cnt()
    {
        return $this->wiz_cnt;
    }

    public function update_user($ob)
    {
        $this->users[$ob->uid] = $ob;
        global $OBJECT;
        $OBJECT->update_user($ob->body);
    }

    public function add_user($uid, $oid, $ob)
    {
        if (!isset($this->users[$uid])) {
            $ob->uid = $uid;
            $this->users[$uid] = $ob;

            global $OBJECT;
            if ($OBJECT->add_user($oid, $ob->body))
                return true;
        }
        return false;
    }    

    public function get_users()
    {
        return $this->users;
    }

    public function remove_user($ob)
    {
        if (isset($this->users[$ob->uid])) {
            unset($this->users[$ob->uid]);

            global $OBJECT;
            $OBJECT->remove_user($ob->body);
            return true;
        }  
        return false;
    }

    public function find_body($id)
    {
        foreach ($this->users as $k => $v) {
            if ($id == $v->body->id) {
               // echo "\nold connect id is " . $v->id;
                return $v;
            }
        }
        return false;
    }

    public function find_player($id)
    {
        foreach ($this->users as $k => $v) {
            if ($id == $v->body->id) {
               // echo "\nold connect id is " . $v->id;
                return $v->body;
            }
        }
        return false;
    }
}