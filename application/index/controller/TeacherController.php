<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Teacher;

class TeacherController extends Controller {
	public function index() {
		$teacher = Teacher::get(1);
		$this->assign('teacher', $teacher);
		return $this->fetch();
	}
}