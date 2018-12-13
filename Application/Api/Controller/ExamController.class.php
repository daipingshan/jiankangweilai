<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/6
 * Time: 16:39
 */

namespace Api\Controller;

/**
 * Class ExamController
 *
 * @package Api\Controller
 */
class ExamController extends CommonController {

    /**
     * 查看测试记录
     */
    public function index() {
        $caregiver_baby_id = I('get.caregiver_baby_id', 0, 'int');
        $count             = $this->_checkCaregiver($caregiver_baby_id);
        if ($count == 0) {
            $this->output('该健康管理员下不存在改养育人信息！');
        }
        $data = M('exam')->alias('e')->where(array('caregiver_baby_id' => $caregiver_baby_id))->join('left join test_paper p ON p.id=e.test_paper_id')->field('e.*,p.test_paper_name')->select();
        $this->output('ok', 'success', $data);
    }

    /**
     * 添加考试记录
     */
    public function add() {
        $caregiver_baby_id = I('post.caregiver_baby_id', 0, 'int');
        $count             = $this->_checkCaregiver($caregiver_baby_id);
        if ($count == 0) {
            $this->output('该健康管理员下不存在改养育人信息！');
        }
        $test_paper_id      = I('post.test_paper_id', 0, 'int');
        $total_question_num = I('post.total_question_num', 0, 'int');
        $total_score        = I('post.total_score', 0, 'int');
        $score              = I('post.score', 0, 'int');
        $error_question     = I('post.error_question', '', 'trim');
        $add_time           = I('post.add_time', '', 'trim');
        if (empty($test_paper_id)) {
            $this->output('考试试卷不能为空！');
        }
        if (empty($total_question_num)) {
            $this->output('试题总数不能为空！');
        }
        if (empty($total_score)) {
            $this->output('试卷总分不能为空！');
        }
        if (empty($score)) {
            $this->output('实际得分不能为空！');
        }
        if (empty($add_time)) {
            $this->output('记录培训时间不能为空！');
        }

        $is_have = M('exam')->where(array('caregiver_baby_id' => $caregiver_baby_id, 'add_time' => $add_time))->count('id');
        if ($is_have > 0) {
            $this->output('该养育人本月考试记录已记录，不能重复记录！');
        }
        $course_id = M('test_paper')->getFieldById($test_paper_id, 'course_id');
        $data      = array(
            'trainer_id'         => $this->user_id,
            'caregiver_baby_id'  => $caregiver_baby_id,
            'test_paper_id'      => $test_paper_id,
            'course_id'          => $course_id,
            'total_question_num' => $total_question_num,
            'total_score'        => $total_score,
            'score'              => $score,
            'error_question'     => $error_question,
            'add_time'           => $add_time
        );
        $res       = M('exam')->add($data);
        if ($res) {
            $this->output('记录成功', 'success');
        } else {
            $this->output('记录失败！');
        }
    }
}