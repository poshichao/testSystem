<?php
namespace app\index\model;

use think\Model;
use app\index\model\Teacher;
use app\index\model\Student;

class Common extends Model {
	public static function login($work_number, $password) {
		$map = array('work_number' => $work_number);
		$Teacher = Teacher::get($map);
		$Student = Student::get($map);
		$result = false;

		if (!is_null($Teacher) && $Teacher->getData('password') === $password) {
			session('teacherId', $Teacher->getData('id'));
			$result = true;
		} else if (!is_null($Student) && $Student->getData('password') === $password) {
			session('studentId', $Student->getData('id'));
			$result = true;
		} else {
			$result = false;
		}

		return $result;
	}

	public static function isLogin() {
		$teacherId = session('teacherId');
		$studentId = session('studentId');

		if (isset($teacherId) || isset($studentId)) {
			return true;
		} else {
			return false;
		}
	}

	public static function logout() {
		session('teacherId', null);
		session('studentId', null);
		return true;
	}
}