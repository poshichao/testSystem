<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12
 * Time: 19:14
 */
namespace app\index\controller;

use app\index\model\Topic;
use think\Controller;
use app\index\controller\IndexController;
use think\Request;

class TopicController extends IndexController
{
    public function index() {
        $Topic = new Topic();

        $Topics = $Topic->select();
        $this->assign('topics', $Topics);
        return $this->fetch();
    }

    public function add() {
        return $this->fetch();
    }

    public function insert() {
        $post = Request::instance()->post();

        $Topic = new Topic();
        $Topic->name = $post['name'];
        $Topic->course_id = $post['course_id'];

        if ($Topic->save()) {
            return $this->success('保存成功！', url('index'));
        } else {
            return $this->error('保存失败！');
        }
    }

    public function edit() {

    }

    public function delete() {

    }
}