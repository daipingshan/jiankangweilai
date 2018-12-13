<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/6
 * Time: 15:32
 */

namespace Api\Controller;

/**
 * Class CourseController
 *
 * @package Api\Controller
 */
class CourseController extends CommonController {

    /**
     * 课程列表
     */
    public function index() {
        $keyword       = I('get.keyword', '', 'trim');
        $is_compulsory = I('get.is_compulsory', 0, 'int');
        $suit_month    = I('get.suit_month', '', 'trim');
        $where         = array();
        if (!empty($keyword)) {
            $where['course_name'] = array('like', "%{$keyword}%");
        }
        if (!empty($is_compulsory)) {
            $where['require'] = $is_compulsory;
        }
        if ($suit_month != '') {
            $where['suit_month'] = $suit_month;
        }
        $data = M('course')->where($where)->field('*,id as course_id')->select();
        $this->output('ok', 'success', $data);
    }

    /**
     * 查看课程详情
     */
    public function detail() {
        $course_id  = I('get.course_id', 0, 'int');
        $suit_month = I('get.suit_month', '', 'trim');
        $where      = array();
        if (empty($course_id) && $suit_month == '') {
            $this->output('请求参数不完整！');
        }
        if ($course_id) {
            $where['id'] = $course_id;
        }
        if ($suit_month) {
            $where['suit_month'] = $suit_month;
            $where['require']    = 1;
        }
        $info              = M('course')->where($where)->field('*,id as course_id')->find();
        $info['knowledge'] = M('knowledge')->where(array('course_id' => $course_id))->field('*,id as knowledge_id')->select();
        $this->output('ok', 'success', $info);
    }

    /**
     * 查看知识点详情
     */
    public function knowledgeDetail() {
        $knowledge_id = I('get.knowledge_id', 0, 'int');
        $info         = M('knowledge')->find($knowledge_id);
        if (empty($knowledge_id) || empty($info)) {
            $this->output('知识点信息不存在！');
        }
        $knowledge_question = M('knowledge_question')->where(array('knowledge_id' => $knowledge_id))->field('*,id as knowledge_question_id')->select();
        foreach ($knowledge_question as &$question) {
            $question['course_id']     = $info['course_id'];
            $question['answer_option'] = json_decode($question['answer_option'], true);
        }
        $info['question'] = $knowledge_question ? array_values($knowledge_question) : array();
        $this->output('ok', 'success', $info);
    }


}