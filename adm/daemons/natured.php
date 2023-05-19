<?php
/**
*  自然气象
*
*/
namespace adm\daemons;

use \Workerman\Lib\Timer;

class natured
{
    public $weather_msg = array("天空中万里无云","几朵淡淡的云彩妆点著清朗的天空","白云在天空中飘来飘去","厚厚的云层堆积在天边","天空中乌云密布");
    public $day_phase;
    public $timer_id;
    public $current_day_phase;

    function __construct() 
    {
        $this->day_phase = $this->read_file(ROOT_DIR . "adm/etc/nature/day_phase");
    }

    public function init_day_phase()
    {
        $h = date('H');
        $m = date('i');
        $t = $h * 60 + $m;

        for ($i = 0; $i < count($this->day_phase); $i++) {
            if ($t >= intval($this->day_phase[$i]["timelong"]))
                $t -= intval($this->day_phase[$i]["timelong"]);
            else
                break;
        }
        if ($i == 0)
            $current_day_phase = count($this->day_phase) - 1;
        else
            $current_day_phase = $i - 1;

        $i = intval($this->day_phase[($current_day_phase + 1) % count($this->day_phase)]["timelong"]) - $t;

        $this->timer_id = Timer::add($i, array($this, 'update_day_phase'), array(), false);
    }

    public function update_day_phase()
    {
        $this->current_day_phase = (++ $this->current_day_phase) % count($this->day_phase);
        global $GAME;
        foreach ($GAME->users as $k => $v) {
            if (isset($v->body->get_env()->outdoor) && $v->body->get_env()->outdoor == true && $v->body->query_temp('block_msg/all') == null) {
                $v->ssend($this->day_phase[$this->current_day_phase]["timedesc"][rand(0,1)]);
            }
        }
        $i = intval($this->day_phase[($this->current_day_phase + 1) % count($this->day_phase)]["timelong"]);
        $this->timer_id = Timer::add($i, array($this, 'update_day_phase'), array(), false);
      //  echo "\ntime = ".time()." phase = ". $this->current_day_phase . " timerid = " . $this->timer_id;
    }

    private function read_file($file)
    {
        $content = file_get_contents($file);
        $tmps = explode("\n",$content);
        $ret = array();
        for ($i = 0; $i< count($tmps); $i++) {
            $j = $i % 5;
            if ($j == 0)
                $ret[$i/5]['timelong'] = $tmps[$i];
            elseif ($j == 1)
                $ret[$i/5]['timedesc'][0] = $tmps[$i];
            elseif ($j == 2)
                $ret[$i/5]['timedesc'][1] = $tmps[$i];
            elseif ($j == 3)
                $ret[$i/5]['timeevent'] = $tmps[$i];
        }
        return $ret;
    }
}
