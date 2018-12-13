<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/3
 * Time: 10:51
 */

namespace Admin\Controller;

/**
 * 课程管理
 * Class CourseController
 *
 * @package Admin\Controller
 */
class CourseController extends CommonController {

    /**
     * 课程列表
     */
    public function index() {
        if (IS_AJAX) {
            $course  = I('get.course', '', 'trim');
            $require = I('get.require', 0, 'int');
            $page    = I('get.page', 1, 'int');
            $limit   = I('get.limit', 10, 'int');
            $model   = M('course');
            $where   = array();
            if ($course) {
                $where['title'] = array('like', "%{$course}%");
            }
            if ($require) {
                $where['require'] = $require;
            }
            $count = $model->where($where)->count('id');
            $data  = $model->where($where)->page($page)->limit($limit)->order('id desc')->select();
            foreach ($data as &$val) {
                $val['knowledge_num'] = M('knowledge')->where(array('course_id' => $val['id']))->count('id');
                if ($val['suit_month'] < 0) {
                    $val['suit_month_view'] = $val['suit_month'] + 10;
                } else {
                    $val['suit_month_view'] = $val['suit_month'];
                }
            }
            $this->output($data, $count);
        } else {
            $this->display();
        }
    }

    /**
     * 添加课程
     */
    public function add() {
        $this->display();
    }

    /**
     * 修改课程
     */
    public function update() {
        $id   = I('get.id', 0, 'int');
        $info = M('course')->find($id);
        $this->assign('info', $info);
        $this->display();
    }

    /**
     * 保存课程
     */
    public function save() {
        if (!IS_AJAX) {
            $this->error('非法请求！');
        }
        $course     = I('post.course', '', 'trim,strip_tags');
        $desc       = I('post.desc', '', 'trim');
        $cover_url  = I('post.cover_url', '', 'trim');
        $suit_month = I('post.suit_month', '', 'trim');
        $require    = I('post.require', 0, 'int');
        $id         = I('post.id', 0, 'int');
        if (empty($course)) {
            $this->error('课程名称不能为空！');
        }
        if (empty($desc)) {
            $this->error('课程简介不能为空！');
        }
        if (empty($cover_url)) {
            $this->error('请上传封面图片！');
        }
        if ($suit_month == '') {
            $this->error('适合月份不能为空！');
        }
        if (empty($require)) {
            $this->error('课程类型不能为空！');
        }
        if ($require == 1) {
            $count = M('course')->where(array('suit_month' => $suit_month, 'require' => 1))->count();
            if ($id > 0) {
                if ($count > 1) {
                    $this->error("适合{$suit_month}个月宝宝大的必修课程已存在！");
                }
            } else {
                if ($count > 0) {
                    $this->error("适合{$suit_month}个月宝宝大的必修课程已存在！");
                }
            }
        }
        $data = array(
            'course'      => $course,
            'desc'        => $desc,
            'cover_url'   => $cover_url,
            'suit_month'  => $suit_month,
            'require'     => $require,
            'update_time' => date('Y-m-d H:i:s'),
        );

        if ($id > 0) {
            $data['id'] = $id;
            $res        = M('course')->save($data);
        } else {
            $data['add_time'] = date('Y-m-d H:i:s');
            $res              = M('course')->add($data);
        }
        if ($res !== false) {
            $this->success('保存成功');
        } else {
            $this->error('保存失败！');
        }
    }

}