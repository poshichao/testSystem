<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12
 * Time: 19:01
 */

namespace app\index\model;

//班级
use think\Model;

class Room extends Model
{
    public function member(){
        return $this->hasMany('Student','room_id','id');
    }

    public function getMemberByID($id){
        $banner = $this->with('member')->find($id);
        return $banner;
    }
}