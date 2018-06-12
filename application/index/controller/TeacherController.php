<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Teacher;
use think\Request;
use app\index\controller\IndexController;

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

	}

	public function delete() {
		
	}
}