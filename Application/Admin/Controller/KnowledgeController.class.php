<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/3
 * Time: 13:49
 */

namespace Admin\Controller;


/**
 * 知识点管理
 * Class KnowledgeController
 *
 * @package Admin\Controller
 */
class KnowledgeController extends CommonController {

    /**
     * 知识点列表
     */
    public function index() {
        if (IS_AJAX) {
            $course_id = I('get.course_id', 0, 'int');
            $title     = I('get.title', '', 'trim');
            $page      = I('get.page', 1, 'int');
            $limit     = I('get.limit', 10, 'int');
            $model     = M('knowledge');
            $where     = array();
            if ($course_id) {
                $where['k.course_id'] = $course_id;
            }
            if ($title) {
                $where['k.title'] = array('like', "%{$title}%");
            }
            $count = $model->alias('k')->where($where)->count('id');
            $data  = $model->alias('k')->join('left join course c ON c.id=k.course_id')->field('k.*,c.course')->where($where)->page($page)->limit($limit)->order('id desc')->select();
            foreach ($data as &$val) {
                $val['paper_num']    = M('test_question')->where(array('knowledge_id' => $val['id']))->count('id');
                $val['question_num'] = M('knowledge_question')->where(array('knowledge_id' => $val['id']))->count('id');
            }
            $this->output($data, $count);
        } else {
            $course_data = $this->_getCourseData();
            $this->assign('course_data', $course_data);
            $this->display();
        }
    }

    /**
     * 添加知识点
     */
    public function add() {
        $course_data = $this->_getCourseData();
        $this->assign('course_data', $course_data);
        $this->display();
    }

    /**
     * 修改知识点
     */
    public function update() {
        $id          = I('get.id', 0, 'int');
        $info        = M('knowledge')->find($id);
        $course_data = $this->_getCourseData();
        $this->assign('course_data', $course_data);
        $this->assign('info', $info);
        $this->display();
    }

    /**
     * 保存知识点
     */
    public function save() {
        if (!IS_AJAX) {
            $this->error('非法请求！');
        }
        $course_id = I('post.course_id', 0, 'int');
        $title     = I('post.title', '', 'trim');
        $theme     = I('post.theme', '', 'trim');
        $desc      = I('post.desc', '', 'trim');
        $video     = I('post.video', '', 'trim');
        $id        = I('post.id', 0, 'int');
        if (empty($course_id)) {
            $this->error('请选择所属课程！');
        }
        if (empty($title)) {
            $this->error('知识点标题不能为空！');
        }
        if (empty($theme)) {
            $this->error('知识点主题不能为空！');
        }
        if (empty($desc)) {
            $this->error('知识点简介不能为空！');
        }
        $data = array(
            'course_id'   => $course_id,
            'title'       => $title,
            'theme'       => $theme,
            'desc'        => $desc,
            'video'       => $video,
            'update_time' => date('Y-m-d H:i:s'),
        );
        if ($id > 0) {
            $data['id'] = $id;
            $res        = M('knowledge')->save($data);
        } else {
            $data['add_time'] = date('Y-m-d H:i:s');
            $res              = M('knowledge')->add($data);
        }
        if ($res !== false) {
            M('course')->where(array('id' => $course_id))->save(array('update_time' => date('Y-m-d H:i:s')));
            $this->success('保存成功');
        } else {
            $this->error('保存失败！');
        }
    }

    /**
     * 获取课程数据
     */
    protected function _getCourseData() {
        $data = M('course')->getField('id,course', true);
        return $data;
    }

    /**
     * 删除知识点
     */
    public function delete() {
        if (!IS_AJAX) {
            $this->error('非法请求！');
        }
        $id   = I('get.id', 0, 'int');
        $info = M('knowledge')->find($id);
        if (empty($id) || empty($info)) {
            $this->error('知识点信息不存在！');
        }
        $res = M('knowledge')->delete($id);
        if ($res !== false) {
            $test_paper_id = M('test_question')->where(array('knowledge_id' => $id))->getField('test_paper_id', true);
            if (count($test_paper_id) > 0) {
                M('test_paper')->where(array('id' => array('in', $test_paper_id)))->save(array('update_time' => date('Y-m-d H:i:s')));
            }
            M('test_question')->where(array('knowledge_id' => $id))->delete();
            $this->_delOss($info['pic']);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

    /**
     * 知识点对应问题管理
     */
    public function question() {
        if (IS_AJAX) {
            $knowledge_id = I('get.knowledge_id', 0, 'int');
            $where        = array();
            if ($knowledge_id) {
                $where['k_q.knowledge_id'] = $knowledge_id;
            }
            $model = M('knowledge_question');
            $count = $model->alias('k_q')->where($where)->count('id');
            $data  = $model->alias('k_q')->join('left join knowledge k ON k.id=k_q.knowledge_id')->field('k_q.*,k.title as knowledge_title')->where($where)->order('id desc')->select();
            foreach ($data as &$val) {
                if ($val['question_type'] == 'select') {
                    $val['question_type'] = '选择题';
                } else {
                    $val['question_type'] = '填空题';
                }
            }
            $this->output($data, $count);
        } else {
            $this->display();
        }
    }

    /**
     * 添加知识点问题
     */
    public function addQuestion() {
        $this->display();
    }

    /**
     * 修改知识点
     */
    public function updateQuestion() {
        $id                    = I('get.id', 0, 'int');
        $info                  = M('knowledge_question')->find($id);
        $info['answer_option'] = json_decode($info['answer_option'], true);
        $this->assign('info', $info);
        $this->display();
    }

    /**
     * 保存知识点
     */
    public function saveQuestion() {
        if (!IS_AJAX) {
            $this->error('非法请求！');
        }
        $knowledge_id       = I('post.knowledge_id', 0, 'int');
        $title              = I('post.title', '', 'trim');
        $question           = I('post.question', '', 'trim');
        $question_type      = I('post.question_type', '', 'trim');
        $select_type        = I('post.select_type', '', 'trim');
        $answer_option      = I('post.answer_option', '', 'trim');
        $desc               = I('post.desc', '', 'trim');
        $video              = I('post.video', '', 'trim');
        $id                 = I('post.id', 0, 'int');
        $answer_option_data = array();
        if (empty($knowledge_id)) {
            $this->error('问题对应知识点异常，请刷新重试！');
        }
        if (empty($question)) {
            $this->error('问题内容不能为空');
        }
        if (empty($question_type)) {
            $this->error('问题类型不能为空');
        }
        if ($question_type == 'select') {
            if (empty($select_type)) {
                $this->error('答案类型不能为空');
            }
            if (empty($answer_option)) {
                $this->error('问题答案选项内容不能为空');
            }
            $error_info = null;
            $num        = 1;
            foreach ($answer_option as $k => $v) {
                if (empty($v)) {
                    $error_info = "第{$num}个答案选项内容不能为空！";
                    break;
                }
                $answer_option_data[] = $v;
                $num++;
            }
            if (!empty($error_info)) {
                $this->error($error_info);
            }
        } else {
            $select_type        = '';
            $answer_option_data = array();
        }
        $data = array(
            'knowledge_id'  => $knowledge_id,
            'title'         => $title,
            'question'      => $question,
            'question_type' => $question_type,
            'select_type'   => $select_type,
            'answer_option' => json_encode($answer_option_data),
            'desc'          => $desc,
            'video'         => $video,
            'update_time'   => date('Y-m-d H:i:s'),
        );
        if ($id > 0) {
            $data['id'] = $id;
            $res        = M('knowledge_question')->save($data);
        } else {
            $data['add_time'] = date('Y-m-d H:i:s');
            $res              = M('knowledge_question')->add($data);
        }
        if ($res !== false) {
            M('knowledge')->where(array('id' => $knowledge_id))->save(array('update_time' => date('Y-m-d H:i:s')));
            $course_id = M('knowledge')->getFieldById($knowledge_id, 'course_id');
            if ($course_id > 0) {
                M('course')->where(array('id' => $course_id))->save(array('update_time' => date('Y-m-d H:i:s')));
            }
            $this->success('保存成功');
        } else {
            $this->error('保存失败！');
        }
    }

    /**
     * 删除知识点
     */
    public function delQuestion() {
        if (!IS_AJAX) {
            $this->error('非法请求！');
        }
        $id   = I('get.id', 0, 'int');
        $info = M('knowledge_question')->find($id);
        if (empty($id) || empty($info)) {
            $this->error('知识点问题不存在！');
        }
        $res = M('knowledge_question')->delete($id);
        if ($res !== false) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

    /**
     * 答案统计
     */
    public function answer() {
        $knowledge_id = I('get.knowledge_id', 0, 'int');
        $question     = M('knowledge_question')->where(array('knowledge_id' => $knowledge_id))->field('id,knowledge_id,question')->select();
        $answer       = M('knowledge_answer')->where(array('knowledge_id' => $knowledge_id))->select();
        $answer_data  = array();
        foreach ($answer as $val) {
            $answer_data[$val['caregiver_id']][$val['knowledge_id']][$val['knowledge_question_id']] = $val;
        }
        $this->assign('question', $question);
        $this->assign('answer_data', $answer_data);
        $this->display();
    }
}