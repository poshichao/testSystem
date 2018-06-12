<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12
 * Time: 19:10
 */

namespace app\index\controller;


use app\index\model\Exam;
use think\Controller;

class ExamController extends Controller
{
    public function index() {
        $Exam = new Exam();

        $Exams = $Exam->select();
        $this->assign('exams', $Exams);
        return $this->fetch();
    }

    public function add() {

    }

    public function edit() {

    }

    public function delete() {

    }
}