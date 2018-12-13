<?php

/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/5/2
 * Time: 11:19
 */

namespace Admin\Controller;

use Common\Controller\CommonBaseController;

/**
 * Class CommonController
 *
 * @package Admin\Controller
 */
class CommonController extends CommonBaseController {

    /**
     * @var bool
     */
    protected $checkUser = true;

    /**
     * @var int
     */
    protected $user_id = 0;

    /**
     * @var array
     */
    protected $user_info = array();

    /**
     * CommonController constructor.
     */
    public function __construct() {
        parent::__construct();
        if ($this->checkUser == true) {
            $this->_checkUser();
        }
        $this->assign('act', CONTROLLER_NAME . "/" . ACTION_NAME);
    }

    /**
     * 检测用户登录状态
     */
    protected function _checkUser() {
        $user_info = session('admin_user_info');
        if ($user_info) {
            $this->user_id   = session('admin_user_id');
            $this->user_info = $user_info;
        } else {
            if (IS_AJAX) {
                $this->error('请登录');
            } else {
                $this->redirect('Login/index');
            }
        }
    }


    /**
     * 表格输出数据格式
     *
     * @param array $data
     * @param int $count
     * @param int $code
     * @param string $msg
     */
    protected function output($data = array(), $count = 0, $code = 0, $msg = 'ok') {
        die(json_encode(array('code' => $code, 'count' => $count, 'data' => $data, 'msg' => $msg)));
    }

    /**
     * 获取健康管理员信息
     *
     * @return array
     */
    protected function _getTrainerData() {
        $data         = array();
        $trainer_data = M('trainer')->where(array('status' => 1))->field('id,real_name,mobile')->select();
        foreach ($trainer_data as $val) {
            $data[$val['id']] = $val['real_name'] . '-' . $val['mobile'];
        }
        return $data;
    }

    /**
     * 获取养育人-宝宝
     */
    public function getCaregiverData() {
        $trainer_id = I('get.trainer_id', 0, 'int');
        $db_data    = M('caregiver_baby')->field('id,caregiver_name,baby_name')->where(array('trainer_id' => $trainer_id))->select();
        $data       = array();
        foreach ($db_data as $val) {
            if ($val['baby_name']) {
                $data[] = array('id' => $val['id'], 'name' => $val['caregiver_name'] . "-" . $val['baby_name']);
            } else {
                $data[] = array('id' => $val['id'], 'name' => $val['caregiver_name']);
            }
        }
        $this->success($data);
    }


}