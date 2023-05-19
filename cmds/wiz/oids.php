<?php
/**
*  显示所有物件信息
*
*/

namespace cmds\wiz;

class oids
{
    function __construct() 
    {

    }

    public function do_cmd($ob, $arg = null) 
    {
        global $OBJECT, $GAME;

        if (!$ob->body->wizardp()) {
            $ob->ssend("什么？");
            return;
        }
        
        if ($arg == 'room')
            $objects = $OBJECT->_rooms;
        elseif ($arg == 'obj')
            $objects = $OBJECT->_objs;
        else
            $objects = array_merge($OBJECT->_rooms, $OBJECT->_objs);

        foreach ($objects as $k => $v) {
            $oid[$k] = $v->oid;
        }
        array_multisort($oid, SORT_ASC, $objects);
        
        $ob->ssend('当前可用OID为' . $GAME->oid);
        $ob->ssend('- OID -- NAME -- BASE -- TYPE -- PLACE -');
        foreach ($objects as $k => $v) {        
            if (!isset($v->name))
                $name = '未命名物件';
            else
                $name = $v->name;

            if (!isset($v->base_name))
                $id = '未知id';
            else
                $id = $v->base_name;

            if (!isset($v->type))
                $type = '未知类型';
            else
                $type = $v->type;

            if (!isset($v->place->id))
                $place = '';
            else
                $place = $v->place->id;
            $ob->ssend($v->oid. ' ' . $name . '(' .$id . ') ' . $type .  ' ' . $place);
        }
    }

    public function help() 
    {
        $ret = "指令格式 : oids<br>这个指令告诉目前系统内存中的物件信息.";
        return $ret;
    }
}
