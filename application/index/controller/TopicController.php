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

class TopicController extends IndexController
{
    public function index() {
        $Topic = new Topic();

        $Topics = $Topic->select();
        $this->assign('topics', $Topics);
        return $this->fetch();
    }

    public function add() {

    }

    public function edit() {

    }

    public function delete() {

    }
}