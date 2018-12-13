<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/6
 * Time: 14:38
 */

namespace Api\Controller;

/**
 * Class TrainController
 *
 * @package Api\Controller
 */
class TrainController extends CommonController {

    /**
     * 入户记录列表
     */
    public function index() {
        $baby_id = I('get.baby_id', 0, 'int');
        $where   = array('baby_id' => $baby_id, 'trainer_id' => $this->user_id);
        $data    = M('train')->where($where)->select();
        $this->output('ok', 'success', $data);
    }

    /**
     * 添加入户记录
     */
    public function add() {
        $caregiver_baby_id = I('post.caregiver_baby_id', 0, 'int');
        $count             = $this->_checkCaregiver($caregiver_baby_id);
        if ($count == 0) {
            $this->output('该健康管理员下不存在改养育人信息！');
        }
        $training_people_name = I('post.training_people_name', '', 'trim');
        $baby_relation        = I('post.baby_relation', '', 'trim');
        $course_id            = I('post.course_id', 0, 'int');
        $training_feedback    = I('post.training_feedback', '', 'trim');
        $test_score           = I('post.test_score', 0, 'int');
        $pic                  = I('post.pic', '', 'trim');
        $start_time           = I('post.start_time', '', 'trim');
        $finish_time          = I('post.finish_time', '', 'trim');
        $add_time             = I('post.add_time', '', 'trim');
        if (empty($training_people_name)) {
            $this->output('实际被培训人不能为空！');
        }
        if (empty($baby_relation)) {
            $this->output('被培训人与宝宝的关系不能为空！');
        }
        if (empty($course_id)) {
            $this->output('培训课程不能为空！');
        }
        if (empty($test_score)) {
            $this->output('课后测试得分不能为空！');
        }
        if (empty($pic)) {
            $this->output('离户照片照片不能为空！');
        }
        if (empty($start_time)) {
            $this->output('入户开始培训时间不能为空！');
        }
        if (empty($finish_time)) {
            $this->output('结束培训时间不能为空！');
        }
        if (empty($add_time)) {
            $this->output('记录培训时间不能为空！');
        }
        $is_have = M('train')->where(array('caregiver_baby_id' => $caregiver_baby_id, 'add_time' => $add_time))->count('id');
        if ($is_have > 0) {
            $this->output('该养育人本月培训记录已记录，不能重复记录！');
        }
        $caregiver_name    = M('caregiver_baby')->getFieldById($caregiver_baby_id, 'caregiver_name');
        $training_feedback = json_decode($training_feedback, true);
        if (!empty($training_feedback) && is_array($training_feedback)) {
            $knowledge_data = array();
            foreach ($training_feedback as $val) {
                $knowledge_data[] = array(
                    'caregiver_id'          => $caregiver_baby_id,
                    'knowledge_id'          => $val['knowledge_id'],
                    'knowledge_question_id' => $val['knowledge_question_id'],
                    'caregiver_name'        => $caregiver_name,
                    'training_people_name'  => $training_people_name,
                    'answer'                => $val['answer'],
                    'add_time'              => $add_time,
                );
            }
            if (!empty($knowledge_data)) {
                M('knowledge_answer')->addAll($knowledge_data);
            }
        }
        $data = array(
            'trainer_id'           => $this->user_id,
            'caregiver_baby_id'    => $caregiver_baby_id,
            'training_people_name' => $training_people_name,
            'baby_relation'        => $baby_relation,
            'course_id'            => $course_id,
            'training_feedback'    => $training_feedback,
            'test_score'           => $test_score,
            'pic'                  => $pic,
            'start_time'           => $start_time,
            'finish_time'          => $finish_time,
            'add_time'             => $add_time
        );
        $res  = M('train')->add($data);
        if ($res) {
            $this->output('记录成功', 'success');
        } else {
            $this->output('记录失败！');
        }
    }
}