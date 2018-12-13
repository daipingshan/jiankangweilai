<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/3
 * Time: 16:40
 */

namespace Admin\Controller;

/**
 * 试题管理
 * Class QuestionController
 *
 * @package Admin\Controller
 */
class QuestionController extends CommonController {

    /**
     * 试题列表
     */
    public function index() {
        if (IS_AJAX) {
            $test_paper_id = I('get.test_paper_id', 0, 'int');
            $knowledge_id  = I('get.knowledge_id ', 0, 'int');
            $question      = I('get.question', '', 'trim');
            $page          = I('get.page', 1, 'int');
            $limit         = I('get.limit', 10, 'int');
            $model         = M('test_question');
            $where         = array();
            if ($test_paper_id) {
                $where['q.test_paper_id'] = $test_paper_id;
            }
            if ($knowledge_id) {
                $where['q.knowledge_id'] = $knowledge_id;
            }
            if ($question) {
                $where['q.question'] = array('like', "%{$question}%");
            }
            $count = $model->alias('q')->where($where)->count('id');
            $field = "q.*,p.test_paper_name,c.course,k.title";
            $join  = array('left join test_paper p ON p.id=q.test_paper_id', 'left join course c ON c.id=q.course_id', 'left join knowledge k ON k.id=q.knowledge_id');
            $data  = $model->alias('q')->join($join)->field($field)->where($where)->page($page)->limit($limit)->order('id desc')->select();
            $this->output($data, $count);
        } else {
            $paper_data = $this->_getPaperData();
            $this->assign('paper_data', $paper_data);
            $this->display();
        }
    }

    /**
     * 获取试卷对应知识点
     */
    public function getKnowledgeData() {
        if (!IS_AJAX) {
            $this->error('非法请求！');
        }
        $test_paper_id = I('get.test_paper_id', 0, 'int');
        $course_id     = M('test_paper')->getFieldById($test_paper_id, 'course_id');
        $data          = M('knowledge')->where(array('course_id' => $course_id))->field('id,title as name')->select();
        $this->success($data);
    }

    /**
     * 添加试题
     */
    public function add() {
        $paper_data = $this->_getPaperData();
        $this->assign('paper_data', $paper_data);
        $this->display();
    }

    /**
     * 修改试卷
     */
    public function update() {
        $id                         = I('get.id', 0, 'int');
        $info                       = M('test_question')->find($id);
        $info['answer_option_data'] = json_decode($info['answer_option'], true);
        $paper_data                 = $this->_getPaperData();
        $this->assign('paper_data', $paper_data);
        $this->assign('info', $info);
        $this->display();
    }

    /**
     * 保存试卷
     */
    public function save() {
        if (!IS_AJAX) {
            $this->error('非法请求！');
        }
        $test_paper_id = I('post.test_paper_id', 0, 'int');
        $knowledge_id  = I('post.knowledge_id', 0, 'int');
        $score         = I('post.score', 0, 'int');
        $select_type   = I('post.select_type', '', 'trim');
        $question      = I('post.question', '', 'trim');
        $answer_option = I('post.answer_option', '', 'trim');
        $explain       = I('post.explain', '', 'trim');
        $id            = I('post.id', 0, 'int');
        if (empty($test_paper_id)) {
            $this->error('请选择所属试卷！');
        }

        $course_id = M('test_paper')->getFieldById($test_paper_id, 'course_id');
        if (empty($course_id)) {
            $this->error('所属试卷中未选择课程，请检查试卷是否异常！');
        }
        if (empty($knowledge_id)) {
            $this->error('请选择所属知识点！');
        }
        if (empty($score)) {
            $this->error('试题分值不能为空！');
        }
        if (empty($select_type)) {
            $this->error('请选择试题类型！');
        }
        if (empty($question)) {
            $this->error('试题问题不能为空！');
        }
        if (empty($answer_option)) {
            $this->error('试题答案选项不能为空！');
        }
        $error_info         = null;
        $answer_option_data = array();
        $num                = 1;
        $answer             = '';
        foreach ($answer_option['type'] as $key => $val) {
            if (empty($answer_option['value'][$key])) {
                $error_info = "第{$num}个答案选项值不能为空！";
                break;
            }
            if ($val == 'text') {
                if (empty($answer_option['content_text'][$key])) {
                    $error_info = "第{$num}个答案选项内容不能为空！";
                    break;
                }
            } else {
                if (empty($answer_option['content_pic'][$key])) {
                    $error_info = "第{$num}个答案选项内容不能为空！";
                    break;
                }
            }
            if ($answer_option['answer'][$key] == 1) {
                $answer .= $answer == '' ? $answer_option['value'][$key] : ',' . $answer_option['value'][$key];
            }
            $answer_option_data[] = array('type' => $val, 'value' => $answer_option['value'][$key], 'content' => $val == 'text' ? $answer_option['content_text'][$key] : $answer_option['content_pic'][$key], 'answer' => intval($answer_option['answer'][$key]));
            $num++;
        }
        if (!empty($error_info)) {
            $this->error($error_info);
        }
        if ($select_type == 'single') {
            if (count($answer_option['answer']) > 1) {
                $this->error('单选试题答案只能为1个！');
            }
        } else {
            if (count($answer_option['answer']) == 1) {
                $this->error('多选试题答案至少为两项！');
            }
        }
        if (empty($explain)) {
            $this->error('试题解释说明不能为空！');
        }
        if ($course_id)
            $data = array(
                'test_paper_id' => $test_paper_id,
                'course_id'     => $course_id,
                'knowledge_id'  => $knowledge_id,
                'score'         => $score,
                'select_type'   => $select_type,
                'question'      => $question,
                'answer_option' => json_encode($answer_option_data),
                'answer'        => $answer,
                'explain'       => $explain,
                'update_time'   => date('Y-m-d H:i:s'),
            );
        if ($id > 0) {
            $data['id'] = $id;
            $res        = M('test_question')->save($data);
        } else {
            $count            = M('test_question')->where(array('test_paper_id' => $test_paper_id))->count('id');
            $data['sn']       = intval($count) + 1;
            $data['add_time'] = date('Y-m-d H:i:s');
            $res              = M('test_question')->add($data);
        }
        if ($res !== false) {
            M('test_paper')->where(array('id' => $test_paper_id))->save(array('update_time' => date('Y-m-d H:i:s')));
            $this->success('保存成功');
        } else {
            $this->error('保存失败！');
        }
    }

    /**
     * 获取试卷数据
     */
    protected function _getPaperData() {
        $data = M('test_paper')->getField('id,test_paper_name', true);
        return $data;
    }

    /**
     * 删除试题
     */
    public function delete() {
        if (!IS_AJAX) {
            $this->error('非法请求！');
        }
        $id   = I('get.id', 0, 'int');
        $info = M('test_question')->find($id);
        if (empty($id) || empty($info)) {
            $this->error('试题信息不存在！');
        }
        $res = M('test_question')->delete($id);
        if ($res !== false) {
            M('test_paper')->where(array('id' => $info['test_paper_id']))->save(array('update_time' => date('Y-m-d H:i:s')));
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

}