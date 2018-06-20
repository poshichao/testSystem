<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/14
 * Time: 18:33
 */

namespace app\index\controller;


use app\index\model\Paper;
use app\index\model\Score;
use think\Request;

class PaperController extends IndexController
{
    public function preview()
    {
        $paperId = Request::instance()->param('id');
        $paper = Paper::getPaperWithItems($paperId);
        $this->assign('Paper', $paper);
        $this->assign('items', $paper->items);
        return $this->fetch();
    }

    public function realtime()
    {
        $paperId = Request::instance()->param('id');
        $paper = Paper::getPaperWithItems($paperId);
        $offset = $paper->time * 60;
        $ept = self::setExpectTime($offset);
        $this->assign('ept', $ept);
        $this->assign('Paper', $paper);
        $this->assign('items', $paper->items);
        return $this->fetch();
    }

    private function setExpectTime($offset)
    {
        $paperId = Request::instance()->param('id');
        $paper = Paper::get($paperId);
        $score = (new Score())->getScoreByExamID($paper->exam_id, session('studentId'));
        $ept = time() + $offset;
        if (!$score->expect_time) {
            $score->expect_time = $ept;
        }
        $score->save();
        return $score->expect_time;
    }

    public function insert() {
        $post = Request::instance()->post();

        $Paper = new Paper();

        $Paper->name = $post['name'];
        $Paper->sex = $post['sex'];
        $Paper->work_number = $post['work_number'];
        $Paper->password = $post['password'];
        $Paper->room_id = $post['room_id'];

        if ($Paper->save()) {
            return $this->success('保存成功！', 'index');
        } else {
            return $this->error('保存失败！');
        }
    }
}