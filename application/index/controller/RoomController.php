<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12
 * Time: 19:01
 */

namespace app\index\controller;


use app\index\model\Room;
use think\Controller;
use app\index\controller\IndexController;

class RoomController extends IndexController
{
    public function index(){
        $Room = new Room();

        $rooms = $Room->select();
        $this->assign('rooms', $rooms);
        return $this->fetch();
    }

    public function add() {

    }

    public function edit() {

    }

    public function delete() {

    }
}