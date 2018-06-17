<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\Common;

class LoginController extends Controller {
	public function index() {
		return $this->fetch('/login');
	}

	public function login() {
		$post = Request::instance()->post();
		
		$work_number = $post['work_number'];
		$password 	 = $post['password'];

		$result = Common::login($work_number, $password);


		if ($result) {
			if (Common::isTeacher()){
				return $this->success('登录成功！', url('Teacher/index'));
			} else {
				return $this->success('登录成功！', url('Member/index'));
			}
		} else {
			return $this->error('用户名或密码错误！', url('index'));
		}
	}

	public function logout() {
		if (Common::logout()) {
			return $this->success('注销成功！', url('index'));
		} else {
			return $this->error('注销失败！');
		}
	}
}