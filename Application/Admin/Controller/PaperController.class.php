<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/3
 * Time: 15:38
 */

namespace Admin\Controller;

/**
 * 试卷管理
 * Class PaperController
 *
 * @package Admin\Controller
 */
class PaperController extends CommonController {

    /**
     * 试卷列表
     */
    public function index() {
        if (IS_AJAX) {
            $course_id       = I('get.course_id', 0, 'int');
            $test_paper_name = I('get.test_paper_name', '', 'trim');
            $page            = I('get.page', 1, 'int');
            $limit           = I('get.limit', 10, 'int');
            $model           = M('test_paper');
            $where           = array();
            if ($course_id) {
                $where['p.course_id'] = $course_id;
            }
            if ($test_paper_name) {
                $where['p.test_paper_name'] = array('like', "%{$test_paper_name}%");
            }
            $count = $model->alias('p')->where($where)->count('id');
            $data  = $model->alias('p')->join('left join course c ON c.id=p.course_id')->field('p.*,c.course')->where($where)->page($page)->limit($limit)->order('id desc')->select();
            foreach ($data as &$val) {
                $question             = M('test_question')->where(array('test_paper_id' => $val['id']))->field('count(id) as num,sum(score) as score')->select();
                $question[0]['num']   = $question[0]['num'] ? : 0;
                $question[0]['score'] = $question[0]['score'] ? : 0;
                $url                  = U('Question/index', array('test_paper_id' => $val['id']));
                $val['question_info'] = "<a href='" . $url . "'>试题数量:【<span style='color: red'>{$question[0]['num']}</span>】，总分：【<span style='color: red'>{$question[0]['score']}</span>】</a>";
            }
            $this->output($data, $count);
        } else {
            $course_data = $this->_getCourseData();
            $this->assign('course_data', $course_data);
            $this->display();
        }
    }

    /**
     * 添加试卷
     */
    public function add() {
        $course_data = $this->_getCourseData();
        $this->assign('course_data', $course_data);
        $this->display();
    }

    /**
     * 修改试卷
     */
    public function update() {
        $id          = I('get.id', 0, 'int');
        $info        = M('test_paper')->find($id);
        $course_data = $this->_getCourseData();
        $this->assign('course_data', $course_data);
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
        $course_id       = I('post.course_id', 0, 'int');
        $test_paper_name = I('post.test_paper_name', '', 'trim,strip_tags');
        $id              = I('post.id', 0, 'int');
        if (empty($course_id) && $id == 0) {
            $this->error('请选择所属课程！');
        }
        if (empty($test_paper_name)) {
            $this->error('试卷名称不能为空！');
        }
        $count = M('test_paper')->where(array('course_id' => $course_id))->count('id');
        if ($id > 0) {
            if ($count > 1) {
                $this->error('该课程下已存在试卷，一个课程下只能添加一套试卷');
            }
        } else {
            if ($count > 0) {
                $this->error('该课程下已存在试卷，一个课程下只能添加一套试卷');
            }
        }
        $suit_month = M('course')->getFieldById($course_id, 'suit_month');
        $data       = array(
            'suit_month'      => $suit_month,
            'test_paper_name' => $test_paper_name,
            'update_time'     => date('Y-m-d H:i:s'),
        );
        if ($id > 0) {
            $data['id'] = $id;
            $res        = M('test_paper')->save($data);
        } else {
            $data['course_id'] = $course_id;
            $data['add_time']  = date('Y-m-d H:i:s');
            $res               = M('test_paper')->add($data);
        }
        if ($res !== false) {
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
}