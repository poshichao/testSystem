<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12
 * Time: 19:10
 */

namespace app\index\controller;

use app\index\model\Common;
use app\index\model\Exam;
use app\index\model\Item;
use app\index\model\Paper;
use app\index\model\Paper_item;
use app\index\model\Room;

use app\index\model\Score;

use think\Request;

class ExamController extends IndexController
{
    public function index() {
        $room_id = Request::instance()->param('id');
        $res = (new Room())->getExamByID($room_id);
        $exams = $res['exam'];
        foreach ($exams as $exam){
            $exam->exam_time = date('Y-m-d H:i:s', $exam->exam_time);
            if($exam->paper == null){
                $exam->paper = "";
            }
        }
        $this->assign('exams', $exams);
        if(Common::isStudent()){
            $scores = (new Score())->getScoreByID(session('studentId'));
//            return json($scores);
            $this->assign('scores', $scores);
        }
        return $this->fetch();
    }

    public function add() {
        return $this->fetch();
    }

    public function insert() {
        $post = Request::instance()->post();

        $Exam = new Exam();

        $Exam->name = $post['name'];
        $Exam->exam_time = $post['exam_time'];
        $Exam->room_id = $post['room_id'];
        $Exam->course_id = $post['course_id'];

        if ($Exam->save()) {
            return $this->success('保存成功！', 'index');
        } else {
            return $this->error('保存失败！');
        }
    }

    public function edit() {
        $ExamId = Request::instance()->param('id');

        if (is_null($Exam = Exam::get($ExamId))) {
            return $this->error('未找到id为' . $ExamId . '的考试！');
        }

        $this->assign('Exam', $Exam);
        return $this->fetch();

    }

    public function delete()
    {
        $id = Request::instance()->param('id');
        $member = Exam::get($id);
        $room_id = Request::instance()->param('room_id');
        if (!is_null($member)) {
            if ($member->delete()) {
                return $this->success('删除成功！', url('index?room_id=' . $room_id));
            } else {
                return $this->error('删除失败！');
            }
        } else {
            return $this->error('未找到id为' . $id . '的对象');
        }

    }

    public function update() {
        $post = Request::instance()->post();
        $ExamId = Request::instance()->param('id/d');

        $Exam = Exam::get($ExamId);


        $Exam->name = $post['name'];
        $Exam->exam_time = $post['exam_time'];
        $Exam->room_id = $post['room_id'];
        $Exam->course_id = $post['course_id'];


        if ($Exam->validate()->save()) {
            return $this->success('保存成功！', url('index'));
        } else {
            return $this->error('保存失败！');
        }
    }
    public function merge(){
        $Item = new Item();
        $ExamId = Request::instance()->param('id/d');
        $Items = $Item->select();

        $this->assign('items', $Items);
        $this->assign('ExamId', $ExamId);
        return $this->fetch();
    }
    public function build(){
        $ExamId = Request::instance()->param('id/d');
        $check =input('post.check/a');
        $name =input('post.name');
        $time =input('post.time');


        $Paper = new Paper();
        $Paper->name = $name;
        $Paper->time = $time;
        $Paper->exam_id = $ExamId;


        if ($Paper->validate()->save()) {
            if(!empty($check)){
                for($i=0;$i<count($check);$i++){
                    $Paper_item = new Paper_item();
                    $Paper_item->item_id = $check[$i];
                    $Paper_item->paper_id = $Paper->id;
                    $Paper_item->save();
                }
            }
            return $this->success('保存成功！', url('index'));
        } else {
            return $this->error('保存失败！');
        }




    }
}