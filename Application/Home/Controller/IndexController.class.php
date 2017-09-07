<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display();
    }

    //取出用户一个月打卡天数
    public function getInfo(){
        $start = strtotime(date('Y-m')); //本月初。
        $end = strtotime(date('Y-m-t')); //本月末。
        $model = D('Sign');
        $data['user_id'] = 1;
        $data['date'] = ['BETWEEN', [$start, $end]];
        $info = $model->where($data)->select();
        echo '<pre>';
        print_r($info);
    }

    public function doAjax(){
        $userId = 1;  //用户id默认1
        $model = D('Sign');
        $data['user_id'] = $userId;
        $data['date'] = time();
        //验证当天是否打卡
        $signInfo = $this->checkSign($userId);
        if($signInfo){
            echo json_encode(['msg' => '已打卡', 'status' => -1, 'data' => []]);
            exit;
        }
        if($model->add($data)){
            $this->addPoint($userId);
            echo json_encode(['msg' => '成功', 'status' => 1, 'data' => []]);
        }else{
            echo json_encode(['msg' => '失败', 'status' => -1, 'data' => []]);
        }
    }

    //添加积分
    protected function addPoint($id){
        $model = D('User');
        $num = $this->checkSignLast($id);
        if($num == 6){
            $model->where("id = $id")->setInc('point', 8); // 用户的积分加8
        }else{
            $model->where("id = $id")->setInc('point', 1); // 用户的积分加1
        }
    }

    //验证用户当天是否打卡
    protected function checkSign($userId){
        $date = date('Y-m-d',time());
        $start = strtotime($date. '00:00');
        $end = strtotime($date. '23:59');
        $model = D('Sign');
        $data['user_id'] = $userId;
        $data['date'] = ['BETWEEN', [$start, $end]];
        $info = $model->where($data)->select();
        return $info;
    }

    //判断用户连续打了几天卡
    protected function checkSignLast($userId){
        $start = strtotime("-6 day");
        $start = date('Y-m-d', $start);
        $start = strtotime($start. '00:00');

        $end = strtotime("-1 day");
        $end = date('Y-m-d', $end);
        $end = strtotime($end. '23:59');
        $model = D('Sign');
        $data['user_id'] = $userId;
        $data['date'] = ['BETWEEN', [$start, $end]];
        $info = $model->where($data)->count();
        return $info;
    }
}