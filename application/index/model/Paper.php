<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/14
 * Time: 18:33
 */

namespace app\index\model;


use think\Model;

class Paper extends Model
{
    protected $hidden = ['exam_id'];

    public function items(){
        return $this->belongsToMany('Item','paper_item',
            'item_id','paper_id');
    }

    public static function getPaperWithItems($id){
        $paper = self::with('items')->find($id);
        return $paper;
    }
}