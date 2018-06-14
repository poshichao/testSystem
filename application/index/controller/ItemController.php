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
use app\index\controller\IndexController;
use think\Request;

class ItemController extends IndexController
{
    public function index() {
        $Item = new Item();

        $Items = $Item->select();
        $this->assign('items', $Items);
        return $this->fetch();
    }

    public function add() {
        return $this->fetch();
    }

    public function insert() {
        $post = Request::instance()->post();

        $Item = new Item();
        $Item->dry = $post['dry'];
        $Item->option = $post['option'];
        $Item->type_id = $post['type_id'];

        if ($Item->save()) {
            return $this->success('保存成功！', url('index'));
        } else {
            return $this->error('保存失败！');
        }
    }

    public function edit() {
        $itemId = Request::instance()->param('id/d');

        $item = Item::get($itemId);
        $this->assign('item', $item);
        return $this->fetch();
    }

    public function update() {
        $itemId = Request::instance()->param('id/d');
        $post = Request::instance()->post();

        $Item = Item::get($itemId);

        if (is_null($Item)) {
            return $this->error('未找到id为' . $itemId . '的对象');
        }
        $Item->dry = $post['dry'];
        $Item->option = $post['option'];

        if ($Item->save()) {
            return $this->success('保存成功！', url('index'));
        } else {
            return $this->error('保存失败！');
        }
    }

    public function delete() {

    }
}