<?php

namespace app\index\model;

use think\Model;

// 学生
class Student extends Model {
	public function scores() {
		return $this->hasMany('Score');
	}
}