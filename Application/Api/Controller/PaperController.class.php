<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/6
 * Time: 15:51
 */

namespace Api\Controller;

/**
 * Class PaperController
 *
 * @package Api\Controller
 */
class PaperController extends CommonController {

    /**
     * 查看试卷列表
     */
    public function index() {
        $course_id  = I('get.course_id', 0, 'int');
        $suit_month = I('get.suit_month', '', 'trim');
        $where      = array();
        if (!empty($course_id)) {
            $where['course_id'] = $course_id;
        }
        if ($suit_month != '') {
            $where['suit_month'] = $suit_month;
        }
        $data = M('test_paper')->where($where)->field('*,id as test_paper_id')->select();
        foreach ($data as &$val) {
            $val['question_num'] = M('test_question')->where(array('test_paper_id' => $val['id']))->count();
            $val['score']        = M('test_question')->where(array('test_paper_id' => $val['id']))->sum('score');
        }
        $this->output('ok', 'success', $data);
    }

    /**
     * 查看试卷详情
     */
    public function detail() {
        $test_paper_id = I('get.test_paper_id', 0, 'int');
        $course_id     = I('get.course_id', 0, 'int');
        $suit_month    = I('get.suit_month', '', 'trim');
        $where         = array();
        if (empty($test_paper_id)) {
            $where['id'] = $test_paper_id;
        }
        if (!empty($course_id)) {
            $where['course_id'] = $course_id;
        }
        if ($suit_month != '') {
            $where['suit_month'] = $suit_month;
        }
        $info     = M('test_paper')->where($where)->field('*,id as test_paper_id')->find();
        $question = M('test_question')->where(array('test_paper_id' => $info['test_paper_id']))->select();
        foreach ($question as &$val) {
            $val['answer_option'] = json_decode($val['answer_option'], true);
        }
        $info['test_question'] = $question;
        $this->output('ok', 'success', $info);
    }

}