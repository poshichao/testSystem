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
        $topicId = Request::instance()->param('id/d');

        $topic = Topic::get($topicId);

        if (is_null($topic)) {
            return $this->error('未找到id为' . $topicId . '的对象！');
        }

        $this->assign('topic', $topic);
        return $this->fetch();
    }

    public function update() {
        $topicId = Request::instance()->param('id/d');
        $post = Request::instance()->post();

        $Topic = Topic::get($topicId);
        if (is_null($Topic)) {
            return $this->error('对象不存在！');
        } else {
            $Topic->name = $post['name'];
            $Topic->course_id = $post['course_id'];
        }

        if ($Topic->validate()->save()) {
            return $this->success('更新成功！', url('index'));
        } else {
            return $this->error('更新失败！');
        }
    }

    public function delete() {
        $topicId = Request::instance()->param('id/d');

        $Topic = Topic::get($topicId);
        if (is_null($Topic)) {
            return $this->error('要删除的对象不存在！');
        } else {
            if ($Topic->delete()) {
                return $this->success('删除成功！', url('index'));
            } else {
                return $this->error('删除失败！');
            }
        }
    }
}