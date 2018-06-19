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
        $this->assign('Paper',$paper);
        $this->assign('items',$paper->items);
        return $this->fetch();
    }

    public function realtime()
    {
        $paperId = Request::instance()->param('id');
        $paper = Paper::getPaperWithItems($paperId);
        $offset = $paper->time * 60;
        $ept = self::setExpectTime($offset);
        $this->assign('ept',$ept);
        $this->assign('Paper',$paper);
        $this->assign('items',$paper->items);
        return $this->fetch();
    }

    private function setExpectTime($offset){
        $paperId = Request::instance()->param('id');
        $paper = Paper::get($paperId);
        $score = (new Score())->getScoreByExamID($paper->exam_id,session('studentId'));
        $ept = time() + $offset;
        $score->expect_time = $ept;
        $score->save();
        return $ept;
    }
}