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

class TypeController extends IndexController
{
    public function index() {
        $Type = new Type();

        $Types = $Type->select();
        $this->assign('types', $Types);
        return $this->fetch();
    }

    public function add() {

    }

    public function edit() {

    }

    public function delete() {

    }
}