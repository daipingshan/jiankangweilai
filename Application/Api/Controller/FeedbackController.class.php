<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/6
 * Time: 15:00
 */

namespace Api\Controller;

/**
 * Class FeedbackController
 *
 * @package Api\Controller
 */
class FeedbackController extends CommonController {

    /**
     * 获取反馈记录
     */
    public function index() {
        $status = I('get.status', '', 'trim');
        $where  = array('trainer_id' => $this->user_id);
        if ($status != '') {
            if ($status == 0) {
                $where['reply'] = '';
            } else {
                $where['reply'] = array('neq', '');
            }
        }
        $data = M('feedback')->where($where)->select();
        foreach ($data as &$val) {
            if ($val['reply']) {
                $val['status_view'] = '已处理';
            } else {
                $val['status_view'] = '未处理';
            }
        }
        $this->output('ok', 'success', $data);
    }

    /**
     * 新增反馈记录
     */
    public function add() {
        $feedback_type = I('post.feedback_type', 0, 'trim');
        $content       = I('post.content', '', 'trim');
        $pics          = I('post.pics', '', 'trim');
        $add_time      = I('post.add_time', '', 'trim');
        if (empty($feedback_type)) {
            $this->output('反馈类型不能为空！');
        }
        if (empty($content)) {
            $this->output('反馈内容不能为空！');
        }
        if (empty($add_time)) {
            $this->output('反馈时间不能为空！');
        }
        if ($pics) {
            $pics = json_encode(explode(',', $pics));
        }
        $data = array(
            'trainer_id'    => $this->user_id,
            'feedback_type' => $feedback_type,
            'content'       => $content,
            'pics'          => $pics,
            'add_time'      => $add_time,
        );
        $res  = M('feedback')->add($data);
        if ($res) {
            $this->output('反馈成功', 'success');
        } else {
            $this->output('反馈失败！');
        }
    }
}