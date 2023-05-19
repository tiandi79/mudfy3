<?php
/**
*    用户对象
*
*/

namespace obj;

use std\char;

class user extends char
{
    public $password, $uid, $score, $last_age_set, $mud_age, $mks, $pks, $killed, $task, $family, $created_item, $created_room, $gift_points, $mystorys;
    public $type = 'user';

    function __construct($ob = null) 
    {
        parent::__construct($this);

        /* 仅新建角色时 */
        if (isset($ob)) {
            $this->password = $ob->ready_to_password;
            $this->id = $ob->ready_to_login;
            $this->name = $ob->ready_to_cname;
            $this->gender = $ob->ready_to_sex;
            $this->birthday = $ob->ready_to_birthday;
            $this->potential = 299;
            $this->title = "普通百姓";
            $this->level = 'player';
            $this->national = $ob->ready_to_national;
            $this->score = 0;
            $this->bellicosity = 0;
            $this->atman = $this->max_atman = $this->force = $this->max_force = $this->mana = $this->max_mana = 0;
            $this->unit = '位';
            $this->mks = $this->pks = $this->killed = 0;
            $this->task = $this->created_item = $this->created_room = 0;
            $this->family = array();
            $this->gift_points = 5;

            switch($this->national) {
            case '汉族':
                $this->set_attribute(5,10,10,10,12,10,10,10,20,5,10,10);
                break;
            case '苗族':
                $this->set_attribute(10,10,20,10,10,10,5,5,10,10,10,20);
                break;
            case '满族':
                $this->set_attribute(10,10,10,5,8,10,10,20,10,10,20,10);
                break;
            case '蒙古族':
                $this->set_attribute(10,20,5,5,10,20,10,10,10,10,10,10);
                break;
            }

            $this->combat_exp = 2000;
            $this->food = $this->max_food_capacity();
            $this->water = $this->max_water_capacity();            
            $mud_age = 0;
        }
        $this->last_age_set = time();
        $have_heart = true;
    }

    public function update_body()
    {
        $this->max_gin = 0;
        $this->max_kee = 0;
        $this->max_sen = 0;

        if ($this->age <= 14)
            $this->max_gin = 100 + $this->spi * 10;
        elseif ($this->age <= 20)
            $this->max_gin = 100 + $this->spi * 10 + ($this->age - 14) * 20;
        elseif ($this->age <= 30)
            $this->max_gin = 220 + $this->spi * 10;
        elseif ($this->age <= 60)
            $this->max_gin = 220 - ($this->age - 30) * 5 + $this->spi * 10;
        else
            $this->max_gin = 70 + $this->spi * 10;
 
        if (isset($this->max_atman) && $this->max_atman > 0)
            $this->max_gin += $this->max_atman;

        $this->max_gin += $this->dur * $this->dur;

        if ($this->age <= 14)
            $this->max_kee = 100 + $this->con * 10;
        elseif ($this->age <= 20)
            $this->max_kee = 100 + $this->con * 10 + ($this->age - 14) * 20;
        else
            $this->max_kee = 220 + $this->con * 10;

        if (isset($this->max_force) && $this->max_force > 0)
            $this->max_kee += $this->max_force;

        $this->max_kee += $this->dur * $this->dur;

        if ($this->age <= 30)
            $this->max_sen = 100 + $this->int * 10;
        else
            $this->max_sen = 100 + ($this->age - 30) * 5 + $this->int * 10;

        if (isset($this->max_mana) && $this->max_mana > 0)
            $this->max_sen += $this->max_mana;

        $this->max_sen += $this->dur * $this->dur;
        $this->update_age();
    }
        
    public function update_age()
    {
        if (!isset($this->last_age_set)) { 
            $this->last_age_set = time();
        }
        $this->mud_age += time() - $this->last_age_set;
        $this->last_age_set = time();
        $this->age = 10 + intval($this->mud_age / SECOND_PER_AGE);
    }

    public function move($object, $silence = false)
    {
        if (parent::move($object, $silence)) {
            global $LOOK_CMD;
            $ob = $this->get_conn();
            if (!$silence)
                $LOOK_CMD->do_cmd($ob);
            return true;
        }
        else
            return false;
    }

    private function set_attribute($tol, $fle, $agi, $dur, $int, $str, $con, $spi, $per, $cor, $cps, $kar)
    {
        $this->tol = $tol;
        $this->fle = $fle;
        $this->agi = $agi;
        $this->dur = $dur;
        $this->int = $int;
        $this->str = $str;
        $this->con = $con;
        $this->spi = $spi;
        $this->per = $per;
        $this->cor = $cor;
        $this->cps = $cps;
        $this->kar = $kar;
        $this->is_player = true;
    }

    public static function query_save_file($id)
    {
	    return ROOT_DIR . 'data/userdata/'. substr($id, 0, 1) . '/' . $id .'.dat';
    }

    private function get_md5_pass($password)
    {
        return md5($password . PASSWORDKEY);
    }

    public function save()
    {
        $this->update_age();
        $file = $this->get_save_file();
        $path = $this->get_save_file_path();
        $save_data = new \stdClass();
        foreach ($this as $k => $v) {
            /* 不保存以下信息 */
            if ($k == 'temp')
                continue;
            if ($k == 'encumbrance')
                continue;
            if ($k == 'last_age_set')
                continue;
            /* md5 password */
            if ($k == 'password' && strlen($v) != 32)
                $save_data->$k = $this->get_md5_pass($v);
            else
                $save_data->$k = $v;
        }

        /* 不保存身上的物件信息 */
        foreach ($save_data as $k => $v) {
            if ($k == 'carry_objects') {
                $objs = null;
                foreach ($v as $kk => $vv) {
                    if ($vv->query('owner') == null)
                        unset($v[$kk]);
                }
                $objs = $v;
            }
        }
        
        $save_data->carry_objects = $objs;

        if (file_exists($file) || is_dir($path)) {
            return file_put_contents($file, serialize($save_data));
        }
        else {
            mkdir($path, '0644');
            return file_put_contents($file, serialize($save_data));
        }
    }

    public function restore($ob)
    {
        $file = ROOT_DIR . 'data/userdata/'. substr($this->id,0,1) . '/' . $this->id . '.dat';
        $data = file_get_contents($file);
        $data = unserialize($data);

        /* 密码错误则直接断开连接，以防止暴力破解 */          
        if ($data->password != $this->get_md5_pass($this->password)) {
            $ob->ssend('密码错误！');
            $ob->destroy();
            return false;
        }
        else {
            foreach ($data as $k => $v) {
                $this->$k = $v;
            }
            $this->update_body();
            return true;
        }        
    }

    private function get_save_file_path()
    {
        return ROOT_DIR . 'data/userdata/'. substr($this->id, 0, 1) . '/';
    }

    private function get_save_file()
    {
        return $this->get_save_file_path() . $this->id .'.dat';
    }

    public function set_story($key)
    {
        $this->mystorys[$key] = time();
        return true;
    }

    public function get_story($key)
    {
        if (isset($this->mystorys[$key]))
            return true;
        else
            return false;
    }
}
