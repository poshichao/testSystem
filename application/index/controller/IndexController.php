<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Common;
use think\Session;

class IndexController extends Controller{
	public function __construct() {
		parent::__construct();

		if (!Common::isLogin()) {
			return $this->error('请先登录！', url('Login/index'));
		} else {
			$teacherId = Session::get('teacherId');
			$studentId = Session::get('studentId');
			$isTeacher = Common::isTeacher();
			$this->assign('isTeacher', $isTeacher);
			$this->assign('teacherId', $teacherId);
			$this->assign('studentId', $studentId);
		}
	}

    public function index()
    {
    }
}
