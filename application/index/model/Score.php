<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/19
 * Time: 18:24
 */

namespace app\index\model;


use think\Model;

class Score extends Model
{
    public function getScoreByID($id){
        return $this->where('student_id','=',$id)->select();
    }
}