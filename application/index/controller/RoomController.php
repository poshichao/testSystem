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

class RoomController extends Controller
{
    public function index(){
        $Room = new Room();

        $rooms = $Room->select();
        $this->assign('rooms', $rooms);
        return $this->fetch();
    }
}