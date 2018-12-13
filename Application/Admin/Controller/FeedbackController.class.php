<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/4
 * Time: 10:47
 */

namespace Admin\Controller;

/**
 * 意见反馈
 * Class FeedbackController
 *
 * @package Admin\Controller
 */
class FeedbackController extends CommonController {

    /**
     * 反馈列表
     */
    public function index() {
        $type_data = array(1 => '小孩相关', 2 => '养育人相关', 3 => '业务相关');
        if (IS_AJAX) {
            $feedback_type = I('get.feedback_type', 0, 'int');
            $content       = I('get.content', '', 'trim');
            $page          = I('get.page', 1, 'int');
            $limit         = I('get.limit', 10, 'int');
            $model         = M('feedback');
            $where         = array();
            if ($feedback_type) {
                $where['f.feedback_type'] = $feedback_type;
            }
            if ($content) {
                $where['f.content'] = array('like', "%{$content}%");
            }
            $count = $model->alias('f')->where($where)->count('id');
            $data  = $model->alias('f')->join('left join trainer t ON t.id=f.trainer_id')->field('f.*,t.mobile,t.real_name')->where($where)->page($page)->limit($limit)->order('id desc,reply_time asc')->select();
            foreach ($data as &$val) {
                $val['type_view']    = $type_data[$val['feedback_type']];
                $val['pics_data']    = json_decode($val['pics'], true);
                $val['trainer_info'] = $val['real_name'] . '-' . $val['mobile'];
            }
            $this->output($data, $count);
        } else {
            $this->assign('type_data', $type_data);
            $this->display();
        }
    }

    /**
     * 回复反馈
     */
    public function reply() {
        $id                = I('get.id', 0, 'int');
        $info              = M('feedback')->find($id);
        $info['pics_data'] = json_decode($info['pics'], true);
        $this->assign('info', $info);
        $this->display();
    }

    /**
     * 回复处理
     */
    public function doReply() {
        if (!IS_AJAX) {
            $this->error('非法请求！');
        }
        $id   = I('post.id', 0, 'int');
        $info = M('feedback')->find($id);
        if (empty($id) || empty($info)) {
            $this->error('反馈信息不存在！');
        }
        $content = I('post.content', '', 'trim');
        if (empty($content)) {
            $this->error('回复内容不能为空！');
        }
        $res = M('feedback')->where(array('id' => $id))->save(array('reply' => $content, 'reply_time' => date('Y-m-d H:i:s')));
        if ($res) {
            $this->success('回复成功');
        } else {
            $this->error('回复失败！');
        }
    }
}