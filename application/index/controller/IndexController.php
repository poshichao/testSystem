<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Common;

class IndexController extends Controller{
	public function __construct() {
		parent::__construct();

		if (!Common::isLogin()) {
			return $this->error('请先登录！', url('Login/index'));
		}
	}

    public function index()
    {
    }
}
