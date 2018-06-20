<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/14
 * Time: 18:33
 */

namespace app\index\controller;


use app\index\model\Exam;
use app\index\model\Paper;
use app\index\model\Score;
use app\index\model\Room;
use think\Request;
use think\Session;

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
        $score = (new Score())->getScoreByExamID($paper->exam_id, session('studentId'));
        $sbt = $score->submit_time;
        if(time()>=$ept || $sbt){
            return $this->error('您已经参加过本场考试！', url('exam/index'));
        }
        $exam = (new Exam())->get($paper->exam_id);
        $ext = $exam->exam_time;
        if(time()>=$ext){
            return $this->error('对不起，考试时间已过！', url('exam/index'));
        }
        $this->assign('ept', $ept);
        $this->assign('Paper', $paper);
        $this->assign('items', $paper->items);
        return $this->fetch();
    }

    private function setExpectTime($offset)
    {
        $paperId = Request::instance()->param('id');
        $paper = Paper::get($paperId);
        $examId = $paper->exam_id;
        $studentId = session('studentId');
        $score = (new Score())->getScoreByExamID($examId,$studentId);
        if(!$score){
            $score = new Score();
            $score->exam_id = $examId;
            $score->student_id = $studentId;
            $score->expect_time = 0;
            $score->submit_time = 0;
        }
        $ept = time() + $offset;
        if (!$score->expect_time) {
            $score->expect_time = $ept;
        }
        $score->save();
        return $score->expect_time;
    }

    public function insert() {
        $post = Request::instance()->post();
        $paperId = Request::instance()->param('id/d');

        $Paper = Paper::get($paperId);
        $studentId = Session::get('studentId');

        $Score = (new Score())->getScoreByExamID($Paper->exam_id,$studentId);
        $Score->score = 0;
        $Score->submit_time = time();

        $i = 0;
        foreach ($Paper->items as $item) {
            if ($item->option === $post['answer'][$i]){
                $Score->score += $item->score;
            }
            $i++;
        }

        if ($Score->save()) {
            return $this->success('保存成功！', url('Exam/index'));
        } else {
            return $this->error('保存失败！');
        }
    }

    public function showScoreList() {
        $examId = Request::instance()->param('id/d');
        $exam = Exam::get($examId);
        $room = Room::get($exam->room_id);
        $members = $room->member()->where('room_id', $exam->room_id)->select();

        $this->assign('exam', $exam);
        $this->assign('room', $room);
        $this->assign('members', $members);
        return $this->fetch('scoreList');
    }
}