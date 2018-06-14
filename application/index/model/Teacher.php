<?php
namespace app\index\model;

use think\Model;

// 老师
class Teacher extends Model {
	public function rooms() {
		return $this->belongsToMany('Room');
	}
}