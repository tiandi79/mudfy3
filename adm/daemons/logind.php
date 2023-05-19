<?php
namespace adm\daemons;

use obj\user;
use std\msg;
use d\fy\fqkhotel;
use \Workerman\Lib\Timer;

class logind
{
    private $channel_id;
    private $timer_debug = false;
    private $national = array("汉族", "苗族", "满族", "蒙古族");
    private $reconnect = false;

    function __construct() 
    {
        $this->channel_id = "连线精灵";
    }

    public static function login($ob) 
    {
        global $CHINESE_D, $UPTIME_CMD, $GAME;
        $GAME->add_login();
        $UPTIME_CMD->do_cmd($ob);
        $ob->ready_to_login = '';
        $ob->ready_to_cname = '';
        $ob->ready_to_password = '';
        $ob->body = '';
        self::show_history($ob);
        $ob->ssend("<div id='logininfo'>目前共有".$CHINESE_D->chinese_number($GAME->get_ppl_cnt())."位人士正在游戏中。其中有".$CHINESE_D->chinese_number($GAME->get_wiz_cnt())."位管理员、及".$CHINESE_D->chinese_number($GAME->get_login_cnt())."位尝试者。</div>", false);
        $ob->ssend("您的英文名字：");
        $ob->status = 'input_id';
    }

    private static function show_history($ob)
    {
        $file = ROOT_DIR . 'data/total.o';
        if (file_exists($file)) 
            $num = file_get_contents($file);                 
        else 
            $num = 0;
 
        $num++;
        file_put_contents($file, $num);
        global $CHINESE_D; 
        $ob->ssend("欢迎第" . $CHINESE_D->chinese_number(intval($num)) . "位访客。");
    }

    public function input_id($ob, $name) 
    {
        if (!$this->check_legal_id($ob, $name)) {
            $ob->ready_to_login = '';
            return false;
        }
        else
            return true;
    }

    public function check_is_exist($ob, $name)
    {
        $savefile = $this->get_save_savefile($name);
        //没有档案，则开始新游戏
        if (!file_exists($savefile)) {
            $ob->ssend("使用 " . $name ."这个名字将会创造一个新的人物，您确定吗(y/n)？");
            $ob->ready_to_login = $name;
            $ob->status = 'confirm_new_player';
        }
        else {
            $ob->ssend("此英文名字已被使用，请输入此帐号的密码：");
            $ob->status = 'get_password';
            $ob->ready_to_login = $name;
        }
        return true;
    }

    public function confirm_kick_player($ob, $yesno)
    {   
        if ($yesno == 'y' || $yesno == 'Y') {            
            return true;
        }
        else {
            $ob->ssend("好吧，欢迎下次再来。");
            $ob->destroy();
            return false;
        }
    }

    public function kick_player($ob)
    {
        global $GAME;
        $ob->ssend('重新连接成功。');
        $ob->status = 'in_game';
        $GAME->remove_login();
        if (isset($ob->ready_to_kick)) {
            $kickob = $ob->ready_to_kick;
            $kickob->ssend("有人从别处连线取代你所控制的人物。");
            $ob->body = $kickob->body;
            $ob->uid = $kickob->uid;
            $GAME->update_user($ob);
            $kickob->destroy();
        }
        if (isset($ob->login_timer)) {
            if (Timer::del($ob->login_timer)) {
                if ($this->timer_debug)
                    echo "\nnow timer = ". $ob->login_timer . ' deleted';
                $ob->login_timer = null;
            }
        }
        $this->reconnect = true;
        $this->enter_world($ob);
    }

    private function enter_world($ob)
    {
        if ($ob->status != 'in_game') {
            $ob->ssend(SYS_ERR);
            return false;
        }
        else {
            global $OBJECT, $UPDATE_D, $GAME;
            $user = $ob->body;
            $UPDATE_D->check_user($user);

            $user->uid = $ob->uid;
            if ($this->reconnect) {
                if (null != $user->get_env())
                    $room = $OBJECT->get_room($user->get_env()->id);
            } 
            elseif (null == $user->query('startroom'))
                $room = $OBJECT->get_room(PLAYER_START_ROOM);
            else 
                $room = $OBJECT->get_room($user->query('startroom'));
            $user->move($room);
            $this->reconnect = false;
            $user->set('last_save', time());
        }
    }

    public function get_password($ob, $pass)
    { 
        $user = new user();
        $user->id = $ob->ready_to_login;
        $user->password = $pass;

        if (!$user->restore($ob)) {
            return false;
        }
        else {
            $ob->body = $user;
            return true;
        }
    }

    public function password_correct($ob)
    {
        global $GAME;
        $user = $ob->body;

        if ($kickob = $GAME->find_body($user->id)) {
            $ob->status = 'confirm_kick_player';
            $ob->ssend("您要将另一个连线中的相同人物赶出去，取而代之吗？(y/n)");
            $ob->ready_to_kick = $kickob;
            //echo "kick connect is ". $kickob->id;       
            return true;
        }
        else {
            $ob->ssend('档案读取成功。');
            $ob->ssend('你重新连线回到这个世界。');
            $GAME->remove_login();
            $ob->status = 'in_game';
            $GAME->add_ppl($ob);
            
            if (isset($ob->login_timer)) {
                if (Timer::del($ob->login_timer)) {
                    if ($this->timer_debug)
                        echo "\nnow timer = ". $ob->login_timer . ' deleted';
                    $ob->login_timer = null;
                }
            }
            $this->enter_world($ob);
            return true;
        }
    }

    public function confirm_new_player($ob, $yesno) 
    {
        if ($yesno == 'y' || $yesno == 'Y') {
            return true;
        }
        else {
            $ob->ssend("好吧，那麽请重新输入您的英文名字：");
            $ob->status = 'input_id';
            return false;
        }
    }

    public function create_new_user($ob)
    {
        if (NEW_USER_LOCK) {
            $ob->ssend("现在" . MUD_NAME ."不接受新的人物，请稍候再创造新的人物。");
            $ob->ssend("好吧，那麽请重新输入您的英文名字：");
            $ob->status = 'input_id';
            return false;
        }
        $ret = "风云Ⅲ是一个以古龙小说为背景的世界，请您想一个有气质，有个性，又不会太奇怪的中文名字，特别要提醒您的是，
请勿使用古龙小说中的人名。这个名字将代表你的人物，而且往後将不能再更改，请务必慎重。如果你有困难输入中文名字，请直接敲回车键［ＲＥＴＵＲＮ］。";
        $ob->ssend($ret);
        $ob->ssend("您的中文名字：");
        $ob->status = 'input_name';
    }

    public function get_name($ob, $cname) 
    {
        if ('' == $cname) {
            $cname = $this->random_name();
            $ob->ssend("看来您要个随机产生的中文名字．．");
            $ob->ssend("您满意(y)不满意(n)这个中文名字？");
            $ob->send($cname);           
            $ob->ready_to_cname = $cname;
            $ob->status = 'confirm_cname';
        }
        else {
            if (!$this->check_legal_cname($ob, $cname)) {
                $ob->ready_to_cname = '';
                return false;
            }
            $ob->ready_to_cname = $cname;
            $ob->ssend("请设定您的密码：");
            $ob->status = 'confirm_first_password';
        }
        return true;
    }

    public function confirm_cname($ob, $yesno)
    {
        if ($yesno == 'y' || $yesno == 'Y') {
            return true;
        }
        else {
            return false;
        }
    }

    public function random_cname_finish($ob)
    {
        if (!$this->check_legal_cname($ob, $ob->ready_to_cname)) {
            $ob->ready_to_cname = '';
            return false;
        }
        $ob->ssend("请设定您的密码：");
        $ob->status = 'confirm_first_password';
    }

    public function random_cname_again($ob)
    {
        $cname = $this->random_name();
        $ob->ssend("看来您要个随机产生的中文名字．．");
        $ob->ssend("您满意(y)不满意(n)这个中文名字？");
        $ob->send($cname);
        $ob->ready_to_cname = $cname;
        $ob->status = 'confirm_cname';
    }

    private function check_legal_cname($ob, $cname)
    {
        $banned_cname = array("你", "我", "他", "她", "它", "它","风云","阿铁", "风云ＩＩ","风云Ⅱ", "汉族","苗族",  "满族","蒙古族","风云ＩＩＩ","风云Ⅲ",	"系统", "核心", "系统核心");

        if (!preg_match("/^[\x7f-\xff]+$/",$cname)) {
            $ob->ssend("对不起，您必须输入中文。");
            $ob->ssend("您的中文名字：");
            $ob->status = 'input_name';
            return false;
        }
        $i = mb_strlen($cname);
        if ($i < 1 && $i > 6) {
            $ob->ssend("对不起，你的中文名字必须是一到六个中文字。");
            $ob->ssend("您的中文名字：");
            $ob->status = 'input_name';
            return false;
        }
        if (in_array($cname,$banned_cname)) {
            $ob->ssend("对不起，这种名字会造成其他人的困扰。");
            $ob->ssend("您的中文名字：");
            $ob->status = 'input_name';
            return false;
        }
        return true;
    }

    public function confirm_first_password($ob, $password)
    {
        if (!$this->check_legal_password($ob, $password)) {
            $ob->ready_to_password = '';
            $ob->ssend("您的密码不符合规定，请重新设定您的密码：");
            $ob->status = 'confirm_first_password';
            return false;
        }
        $ob->ready_to_password = $password;
        return true;
    }

    public function input_repeat_password($ob)
    {        
        $ob->ssend("请再输入一遍密码：");
        $ob->status = 'repeat_password';
    }

    public function confirm_repeat_password($ob, $password)
    {
        if (!$this->check_legal_password($ob, $password)) {
            $ob->ready_to_password = '';
            return false;
        }

        if ($ob->ready_to_password != $password) {
            $ob->ssend("两次密码不一致，请重新输入密码：");
            $ob->status = 'confirm_first_password';
            $ob->ready_to_password = '';
            return false;
        }
        return true;
    }

    public function confirm_sex($ob, $sex)
    {
        if ($sex == 'm' || $sex == 'M' || $sex == 'f' || $sex == 'F' ) {
            $ob->ready_to_sex = $sex;
            return true;
        }
        else {
            $ob->ssend("对不起，您只能选择男性(m)或女性(f)的角色：");
            return false;
        }
    }

    public function set_sex($ob)
    {
        if (strtoupper($ob->ready_to_sex) == 'M')
            $ob->ready_to_sex = '男性';
        else
            $ob->ready_to_sex = '女性';
        $ob->status = 'choice_national';
        $ob->ssend("０．汉族<br>１．苗族<br>２．满族<br>3．蒙古族<br>请选择你在风云Ⅲ中的民族（0，1，2，3）：");
    }

    public function confirm_national($ob, $race)
    {
        if ($race == '0' || $race == '1' || $race == '2' || $race == '3') {
            $ob->ready_to_national = $this->national[$race];
            return true;
        }
        else {
            $ob->ssend("对不起，您只能从（0,1,2,3）中选择： ");
            return false;
        }
    }

    public function choice_sex($ob)
    {
        $ob->ssend("您要扮演男性(m)的角色或女性(f)的角色？");
        $ob->status = 'confirm_sex';
    }

    public function readycreate($ob)
    {
        $ob->ready_to_birthday = time();
        $user = new user($ob);
        $ob->body = $user;

        if ($user->save()) {
            $ob->ssend("用户档案保存成功。");
            $ob->ssend("欢迎进入" . MUD_NAME ."的世界。");
            $ob->status = 'in_game';
            global $GAME;
            $GAME->add_ppl($ob);

            if (isset($ob->login_timer)) {
                if (Timer::del($ob->login_timer)) {
                    if ($this->timer_debug)
                        echo "\nnow timer = ". $ob->login_timer . ' deleted';
                    $ob->login_timer = null;
                }
            }
            $this->enter_world($ob);
        }
        else {
            $ob->ssend("用户档案保存失败。");
            $ob->status = '';
            $ob->ssend(SYSERR);
            return;
        }
    }

    private function check_legal_password($ob, $password) 
    {
        return true;
    }

    private function random_name()
    {
        global $CHINESE_D;
        $firstname = array("赵","钱","孙","李","周","吴","郑","王","冯","陈","褚","卫","蒋","沈","韩","杨","朱","秦","尤","许","何","吕","施","张",
"孔","曹","严","华","金","魏","陶","姜","戚","谢","邹","喻","柏","水","窦","章","云","苏","潘","葛","奚","范","彭","郎","鲁","韦","昌","马","苗","凤","花","方","傻","任","袁","柳","邓","鲍","史","唐","费","廉","岑","薛","雷","贺","倪","汤","藤","殷","罗","华","郝","邬","安","常","乐","呆","时","付","皮","卞","齐","康","伍","余","元","卜","顾","盈","平","黄","和","穆","肖","尹","姚","邵","湛","汪","祁","毛","禹","狄","米","贝","明","藏","计","伏","成","戴","谈","宋","茅","庞","熊","纪","舒","屈","项","祝","董","梁","樊","胡","凌","霍","虞","万","支","柯","昝","管","卢","英","万","候","司马","上官","欧阳","夏候","诸葛","闻人","东方","赫连","皇甫","尉迟","公羊","澹台","公治","宗政","濮阳","淳于","单于","太叔","申屠","公孙","仲孙","辕轩","令狐","钟离","宇文",
"长孙","幕容","司徒","师空","颛孔","端木","巫马","公西","漆雕","乐正","壤驷","公良","拓趾","夹谷","宰父","谷梁","楚晋","阎法","汝鄢","涂钦","段千","百里","东郭","南郭","呼延","归海","羊舌","微生","岳","帅","缑","亢","况","后","有","琴","梁丘","左丘","东门","西门","商","牟","佘","耳","佰赏","南","墨","哈","谯","年","爱","阳","佟","第","五","言","福");
        return ($firstname[rand(0, sizeof($firstname))] . $CHINESE_D->chinese_number(rand(0,20)));
    }

    private function get_save_savefile($name) 
    {
        return user::query_save_file($name);
    }

    private function check_legal_id($ob, $name) 
    {
        $i = strlen($name);
        
        if((strlen($name) < 3) || (strlen($name) > 10 ) ) {
            $ob->ssend("对不起，你的英文名字必须是 3 到 10 个英文字母。");
            $ob->ssend("您的英文名字：");
            $ob->status = 'input_id'; 
            return false;
        }
        while($i--)
            if($name[$i] < 'a' || $name[$i] > 'z' ) {
                $ob->ssend("对不起，你的英文名字只能用英文字母。");
                $ob->ssend("您的英文名字：");
                $ob->status = 'input_id'; 
                return false;
        }
        /* 非法名字判断 */
        if($this->check_intra_name($name)) {
            $ob->ssend("对不起，这种英文名字会造成其他人的困扰。");
            $ob->ssend("您的英文名字：");
            $ob->status = 'input_id'; 
            return false;
        }
        return true;
    }

    private function check_intra_name($name) 
    {
        $banned_id = array("chat", "new", "fy", "rumor", "tell", "none", "reboot", "shutdown","core", "fymud","mud", "fuck", "dick", "shit","cao","cunt","slut", "admin",'npc');
        if (in_array($name,$banned_id))
            return true;
        else
            return false;
    }
}
