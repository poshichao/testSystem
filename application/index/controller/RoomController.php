<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12
 * Time: 19:01
 */

namespace app\index\controller;


use app\index\model\Room;
use app\index\model\Student;

use think\Request;

class RoomController extends IndexController
{
    public function index()
    {
        $Room = new Room();

        $rooms = $Room->select();
        $this->assign('rooms', $rooms);
        return $this->fetch();
    }

    public function add() {
        return $this->fetch();
    }

    public function insert() {
        $post = Request::instance()->post();

        $Room = new Room();

        $Room->name = $post['name'];

        if ($Room->save()) {
            return $this->success('保存成功！', 'index');
        } else {
            return $this->error('保存失败！');
        }
    }

    public function edit() {
        $roomId = Request::instance()->param('id');

        if (is_null($Room = Room::get($roomId))) {
            return $this->error('未找到id为' . $roomId . '的班级！');
        }

        $this->assign('Room', $Room);
        return $this->fetch();

    }

    public function delete()
    {
        $id = Request::instance()->param('id');
        $member = Room::get($id);
        $room_id = Request::instance()->param('room_id');
        if (!is_null($member)) {
            if ($member->delete()) {
                return $this->success('删除成功！', url('index?room_id=' . $room_id));
            } else {
                return $this->error('删除失败！');
            }
        } else {
            return $this->error('未找到id为' . $id . '的对象');
        }

    }

    public function update() {
        $post = Request::instance()->post();
        $roomId = Request::instance()->param('id/d');

        $Room = Room::get($roomId);

        $Room->name = $post['name'];

        if ($Room->validate()->save()) {
            return $this->success('保存成功！', url('index'));
        } else {
            return $this->error('保存失败！');
        }
    }


}