<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Teacher;
use think\Request;
use app\index\controller\IndexController;
use think\Session;

class TeacherController extends IndexController {
	public function index() {
		$Teacher = new Teacher();

		$teachers = $Teacher->select();
		
		$this->assign('teachers', $teachers);
		return $this->fetch();
	}

	public function add() {
		return $this->fetch();
	}

	public function insert() {
		$post = Request::instance()->post();
		
		$Teacher = new Teacher();

		$Teacher->name = $post['name'];
		$Teacher->sex = $post['sex'];
		$Teacher->work_number = $post['work_number'];
		$Teacher->password = $post['password'];
		$Teacher->klass_id = $post['klass_id'];

		if ($Teacher->save()) {
			return $this->success('保存成功！', 'index');
		} else {
			return $this->error('保存失败！');
		}
	}

	public function edit() {
		$teacherId = Request::instance()->param('id/d');

		if (is_null($Teacher = Teacher::get($teacherId))) {
			return $this->error('未找到id为' . $teacherId . '的教师！');
		}

		$this->assign('Teacher', $Teacher);
		return $this->fetch();

	}

	public function update() {
		$post = Request::instance()->post();
		$teacherId = Request::instance()->param('id/d');

		$Teacher = Teacher::get($teacherId);
		$Teacher->name = $post['name'];
		$Teacher->sex = $post['sex'];
		$Teacher->password = $post['password'];
		$Teacher->work_number = $post['work_number'];
		$Teacher->klass_id = $post['klass_id'];

		if ($Teacher->validate()->save()) {
			return $this->success('保存成功！', url('index'));
		} else {
			return $this->error('保存失败！');
		}
	}

	public function delete() {
		$teacherId = Request::instance()->param('id/d');

		$Teacher = Teacher::get($teacherId);
		if (!is_null($Teacher)) {
			if ($Teacher->delete()) {
				return $this->success('删除成功！', url('index'));
			} else {
				return $this->error('删除失败！');
			}
		} else {
			return $this->error('未找到id为' . $teacherId . '的对象');
		}
	}
}