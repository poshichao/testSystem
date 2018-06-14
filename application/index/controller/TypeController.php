<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12
 * Time: 19:15
 */

namespace app\index\controller;


use app\index\model\Type;
use think\Controller;
use app\index\controller\IndexController;
use think\Request;

class TypeController extends IndexController
{
    public function index() {
        $Type = new Type();

        $Types = $Type->select();
        $this->assign('types', $Types);
        return $this->fetch();
    }

    public function add() {
        return $this->fetch();
    }

    public function insert() {
        $post = Request::instance()->post();

        $Type = new Type();
        $Type->name = $post['name'];

        if ($Type->save()) {
            return $this->success('保存成功！', url('index'));
        } else {
            return $this->error('保存失败！');
        }
    }

    public function edit() {
        $typeId = Request::instance()->param('id/d');

        $Type = Type::get($typeId);
        if (is_null($Type)) {
            return $this->error('未找到id为' . $typeId . '的对象！');
        }
        $this->assign('type', $Type);
        return $this->fetch();
    }

    public function update() {
        $typeId = Request::instance()->param('id/d');
        $post = Request::instance()->post();

        $Type = Type::get($typeId);
        $Type->name = $post['name'];

        if ($Type->validate()->save()) {
            return $this->success('保存成功！',url('index'));
        } else {
            return $this->error('保存失败！');
        }
    }

    public function delete() {
        $typeId = Request::instance()->param('id/d');

        $Type = Type::get($typeId);
        if ($Type->delete()) {
            return $this->success('删除成功！', url('index'));
        } else {
            return $this->error('删除失败！');
        }
    }
}