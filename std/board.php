<?php
/**
*   留言板类
*
*/
namespace std;

class board extends obj
{
    public $posts = array();
    public $posts_count = 0;
    function __construct()
    {
        parent::__construct();
        $this->set('no_get', 1);
        $this->set_weight(9999999);
    }

    public function do_read($ob, $postid)
    {   
        $file = $this->query_save_file();
        if (!file_exists($file)) {
            $ob->ssend('留言板上目前没有任何留言。');
            return true;
        }
    
        $text = unserialize(file_get_contents($file));
        $i = 1;
        $posts = array();
        foreach ($text as $v) {
            $posts[$i] = $v;
            $i++;
            if ($i > $this->query('capacity'))
                break;
        }
        
        if ($postid == null) {  
            $ob->ssend('编号 -- 时间 -- 作者 -- 标题');   
            foreach ($posts as $k => $v) {                 
                $ob->ssend($k . ' ' . date("Y-m-d H:i", $v['time']) . ' ' . $v['author'] . ' ' . $v['title']); 
            }
        }
        elseif (is_numeric($postid)) {
            if (isset($posts[$postid])) {
                $ob->ssend('标题：' . $posts[$postid]['title']);
                $ob->ssend('作者：' . $posts[$postid]['author']);
                $ob->ssend($posts[$postid]['content']);
            }
            else
                $ob->ssend('没有该编号的留言。');
        }
        else
            $ob->ssend('留言编号只能为数字。');
        return true;
    }

    private function query_save_file()
    {
	    return ROOT_DIR . 'data/board/'. $this->query('id') .'.dat';
    }

    public function do_post($ob, $title)
    {
        if (null == $title) {
            $ob->ssend('留言请指定一个标题。');
            return true;
        }

        $me = $ob->body;

        $post['title'] = $title;
        $post['author'] = $me->name . '(' . $me->id . ')';
        $post['author_id'] = $me->id;
        $post['time'] = time();
        $post['content'] = '';
        
        $ob->ssend("结束离开用 '.'，取消输入用 '~q'。");
        $ob->ssend('—————————————————————————————');
        $me->set_temp('input_board', $post);
        $me->set_temp("block_msg/all", 1);
        return true;
    }

    public function do_postdone($ob)
    {
        $post = $ob->body->query_temp('input_board');
        $ob->body->set_temp('input_board', null);
        $file = $this->query_save_file();
        if (!file_exists($file)) {
            $posts = array($post);
            file_put_contents($file, serialize($posts));
        } else {
            $posts = unserialize(file_get_contents($file));
            array_unshift($posts, $post);
            file_put_contents($file, serialize($posts));
        }
        $ob->ssend('留言完毕。');
        $i = 1;
        $text = $posts;
        $posts = array();
        foreach ($text as $v) {
            $posts[$i] = $v;
            $i++;
        }
        $this->posts = $posts;
        $this->set('posts_count', count($this->posts));
        $ob->body->set_temp('input_board', null);
        return true;
    }

    public function init_board()
    {
        $file = $this->query_save_file();
        if (file_exists($file)) {
            $text = unserialize(file_get_contents($file));
            $i = 1;
            $posts = array();
            foreach ($text as $v) {
                $posts[$i] = $v;
                $i++;
            }
            $this->posts = $posts;
        }
        $this->set('posts_count', count($this->posts));
    }

    public function do_discard($ob, $postid)
    {
        if (null == $postid) {
            $ob->ssend('指令格式：discard <留言编号>');
        } elseif (!isset($this->posts[$postid])) {
            $ob->ssend('没有这条留言。');
        } elseif ($this->posts[$postid]['author_id'] != $ob->body->id && !$ob->body->wizardp()) {
            $ob->ssend('你只能删除自己的留言。');
        } else {
            unset($this->posts[$postid]);
            $this->set('posts_count', count($this->posts));
            
            $file = $this->query_save_file();
            if (file_put_contents($file, serialize($this->posts)))
                $ob->ssend('留言删除成功。');
            else
                $ob->ssend('留言删除失败。');
        }
        return true;
    }
}
