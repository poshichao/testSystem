<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/14
 * Time: 11:16
 */

namespace app\index\controller;


use app\index\model\Room;
use app\index\model\Student;
use think\Request;

class MemberController extends IndexController
{
    public function index()
    {

        $room_id = Request::instance()->param('room_id');
        $res = (new Room())->getMemberByID($room_id);
        $this->assign('students', $res['member']);
        return $this->fetch();
    }
    public function add() {
        return $this->fetch();
    }

    public function insert() {
        $post = Request::instance()->post();

        $Student = new Student();

        $Student->name = $post['name'];
        $Student->sex = $post['sex'];
        $Student->work_number = $post['work_number'];
        $Student->password = $post['password'];
        $Student->room_id = $post['room_id'];

        if ($Student->save()) {
            return $this->success('保存成功！', 'index');
        } else {
            return $this->error('保存失败！');
        }
    }

    public function edit() {
        $studentId = Request::instance()->param('id');

        if (is_null($Student = Student::get($studentId))) {
            return $this->error('未找到id为' . $studentId . '的学生！');
        }

        $this->assign('Student', $Student);
        return $this->fetch();

    }

    public function delete()
    {
        $id = Request::instance()->param('id');
        $member = Student::get($id);
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
        $studentId = Request::instance()->param('id/d');

        $Student = Student::get($studentId);

        $Student->name = $post['name'];
        $Student->sex = $post['sex'];
        $Student->password = $post['password'];
        $Student->work_number = $post['work_number'];

        if ($Student->validate()->save()) {
            return $this->success('保存成功！', url('index'));
        } else {
            return $this->error('保存失败！');
        }
    }
}