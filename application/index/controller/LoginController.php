<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\Teacher;

class LoginController extends Controller {
	public function index() {
		return $this->fetch('/login');
	}

	public function login() {
		$post = Request::instance()->post();
		
		$map = array('work_number' => $post['work_number']);
		$Teacher = Teacher::get($map);

		if (!is_null($Teacher) && $Teacher->getData('password') === $post['password']) {
			session('teacherId', $Teacher->getData('id'));
			return $this->success('登录成功！', url('Teacher/index'));
		} else {
			return $this->error('用户名或密码错误！', url('index'));
		}
	}
}