<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Course;
use think\Request;
use app\index\controller\IndexController;

class CourseController extends IndexController {
	public function index() {
		$courses = Course::select();
		$this->assign('courses', $courses);
		return $this->fetch();
	}

	public function add() {
        return $this->fetch();
    }

    public function insert() {
        $post = Request::instance()->post();

        $Course = new Course();
        $Course->name = $post['name'];

        if ($Course->save()) {
            return $this->success('保存成功！', url('index'));
        } else {
            return $this->error('保存失败！');
        }
    }

    public function edit() {
        $courseId = Request::instance()->param('id/d');

        $course = Course::get($courseId);
        $this->assign('course', $course);
        return $this->fetch();
    }

    public function update() {
        $courseId = Request::instance()->param('id/d');
        $post = Request::instance()->post();

        $Course = Course::get($courseId);

        if (is_null($Course)) {
            return $this->error('未找到id为' . $courseId . '的对象');
        }
        $Course->name = $post['name'];

        if ($Course->save()) {
            return $this->success('保存成功！', url('index'));
        } else {
            return $this->error('保存失败！');
        }
    }

    public function delete() {
        $courseId = Request::instance()->param('id/d');
        $Course = Course::get($courseId);

        if ($Course->delete()) {
            return $this->success('删除成功！', url('index'));
        } else {
            return $this->error('删除失败！');
        }
    }
}