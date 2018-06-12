<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12
 * Time: 19:14
 */

namespace app\index\controller;

use app\index\model\Item;
use think\Controller;

class ItemController extends Controller
{
    public function index() {
        $Item = new Item();

        $Items = $Item->select();
        $this->assign('items', $Items);
        return $this->fetch();
    }

    public function add() {

    }

    public function edit() {

    }

    public function delete() {

    }
}