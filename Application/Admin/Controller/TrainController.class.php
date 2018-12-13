<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/6
 * Time: 17:39
 */

namespace Admin\Controller;


class TrainController extends CommonController {

    /**
     * 入户记录
     */
    public function index() {
        if (IS_AJAX) {
            $trainer_id        = I('get.trainer_id', 0, 'int');
            $caregiver_baby_id = I('get.caregiver_baby_id', 0, 'int');
            $add_time          = I('get.add_time', '', 'trim');
            $page              = I('get.page', 1, 'int');
            $limit             = I('get.limit', 10, 'int');
            $model             = M('train');
            $where             = array();
            if ($trainer_id) {
                $where['t.trainer_id'] = $trainer_id;
            }
            if ($caregiver_baby_id) {
                $where['t.caregiver_baby_id'] = $caregiver_baby_id;
            }
            if ($add_time) {
                list($start_time, $end_time) = explode(' ~ ', $add_time);
                if ($start_time && $end_time) {
                    $start_time                          = strtotime($start_time);
                    $end_time                            = strtotime($end_time) + 86399;
                    $where['UNIX_TIMESTAMP(t.add_time)'] = array('between', array($start_time, $end_time));
                }
            }
            $count = $model->alias('t')->where($where)->count('id');
            $join  = array("left join trainer t_n ON t_n.id=t.trainer_id", "left join caregiver_baby c_b ON c_b.id=t.caregiver_baby_id", "left join course c ON c.id=t.course_id");
            $data  = $model->alias('t')->join($join)->field('t.*,t_n.real_name,t_n.mobile,c_b.caregiver_name,c_b.baby_name,c.course')->where($where)->page($page)->limit($limit)->order('id desc')->select();
            foreach ($data as &$val) {
                $val['trainer_info'] = $val['real_name'] . '-' . $val['mobile'];
                if ($val['baby_name']) {
                    $val['baby_info'] = $val['caregiver_name'] . "-" . $val['baby_name'];
                } else {
                    $val['baby_info'] = $val['caregiver_name'];
                }
            }
            $this->output($data, $count);
        } else {
            $trainer_data = $this->_getTrainerData();
            $this->assign('trainer_data', $trainer_data);
            $this->display();
        }
    }

}