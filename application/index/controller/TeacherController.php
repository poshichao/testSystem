<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Teacher;
use think\Request;
use app\index\controller\IndexController;
use app\index\model\Course;

class TeacherController extends IndexController {
	public function index() {
		$Teacher = new Teacher();

		$teachers = $Teacher->select();
		
		$this->assign('teachers', $teachers);
		return $this->fetch();
	}

	public function add() {
		$Course = new Course();
		$courses = $Course->select();
		
		$this->assign('courses', $courses);
		return $this->fetch();
	}

	public function insert() {
		$post = Request::instance()->post();
		$courseIds = Request::instance()->post('course_id/a');
		$Teacher = new Teacher();

		$Teacher->name = $post['name'];
		$Teacher->sex = $post['sex'];
		$Teacher->work_number = $post['work_number'];
		$Teacher->password = $post['password'];

		if ($Teacher->save()) {
			$Teacher->courses()->attach($courseIds);
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
		$Course = new Course();
		$courses = $Course->select();

		$this->assign('courses', $courses);
		$this->assign('Teacher', $Teacher);
		return $this->fetch();

	}

	public function update() {
		$post = Request::instance()->post();
		$teacherId = Request::instance()->param('id/d');

		$courseIds = $post['course_id'];

		$Teacher = Teacher::get($teacherId);
		$Teacher->name = $post['name'];
		$Teacher->sex = $post['sex'];
		$Teacher->password = $post['password'];
		$Teacher->work_number = $post['work_number'];
		$courses = $Teacher->courses;

		if ($Teacher->isUpdate()->save()) {
			foreach ($courses as $course) {
				$Teacher->courses()->detach($course->id);
			}
			$Teacher->courses()->attach($courseIds);
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
				$courses = $Teacher->courses;
				foreach ($courses as $course) {
					$Teacher->courses()->detach($course->id);
				}
				return $this->success('删除成功！', url('index'));
			} else {
				return $this->error('删除失败！');
			}
		} else {
			return $this->error('未找到id为' . $teacherId . '的对象');
		}
	}
}