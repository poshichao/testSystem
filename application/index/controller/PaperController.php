<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/14
 * Time: 18:33
 */

namespace app\index\controller;


use app\index\model\Paper;
use think\Request;

class PaperController extends IndexController
{
    public function preview()
    {
        $paperId = Request::instance()->param('id');
        $paper = Paper::getPaperWithItems($paperId);
        $this->assign('Paper',$paper);
        $this->assign('items',$paper->items);
        return $this->fetch();
    }

    public function realtime()
    {
        $paperId = Request::instance()->param('id');
        $paper = Paper::getPaperWithItems($paperId);
        $this->assign('Paper',$paper);
        $this->assign('items',$paper->items);
        return $this->fetch();
    }

    public function insert() {
        $post = Request::instance()->post();

        $Student = new Student();

        $Student->name = $post['name'];
        $Student->sex = $post['sex'];
        $Student->work_number = $post['work_number'];
        $Student->password = $post['password'];
        $Student->room_id = $post['room_id'];

        if ($Student->save()) {
            return $this->success('保存成功！', 'index');
        } else {
            return $this->error('保存失败！');
        }
    }
}