<?php
namespace app\index\model;

use think\Model;

// 老师
class Teacher extends Model {
	public function courses() {
		return $this->belongsToMany('Course');
	}
}