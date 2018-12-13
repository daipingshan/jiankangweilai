<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/2
 * Time: 14:56
 */

namespace Admin\Controller;

/**
 * 广告管理
 * Class AdvertController
 *
 * @package Admin\Controller
 */
class AdvertController extends CommonController {

    /**
     * 广告列表
     */
    public function index() {
        if (IS_AJAX) {
            $title  = I('get.title', '', 'trim');
            $status = I('get.status', 0, 'int');
            $type   = I('get.type', 0, 'int');
            $page   = I('get.page', 1, 'int');
            $limit  = I('get.limit', 10, 'int');
            $model  = M('advert');
            $where  = array();
            if ($title) {
                $where['title'] = array('like', "%{$title}%");
            }
            if ($type) {
                $where['type'] = $type;
            }
            if ($status) {
                $where['status'] = $status;
            }
            $count    = $model->where($where)->count('id');
            $data     = $model->where($where)->page($page)->limit($limit)->order('sort asc, id desc')->select();
            $type_arr = array(1 => '不跳转', 2 => 'url链接');
            foreach ($data as &$val) {
                $val['type_view'] = $type_arr[$val['type']];
            }
            $this->output($data, $count);
        } else {
            $this->display();
        }
    }

    /**
     * 添加广告
     */
    public function add() {
        $this->display();
    }

    /**
     * 修改广告
     */
    public function update() {
        $id   = I('get.id', 0, 'int');
        $info = M('advert')->find($id);
        $this->assign('info', $info);
        $this->display();
    }

    /**
     * 保存广告
     */
    public function save() {
        if (!IS_AJAX) {
            $this->error('非法请求！');
        }
        $title   = I('post.title', '', 'trim,strip_tags');
        $pic     = I('post.pic', '', 'trim');
        $type    = I('post.type', 0, 'int');
        $content = I('post.content', '', 'trim');
        $sort    = I('post.sort', 255, 'int');
        $id      = I('post.id', 0, 'int');
        if (empty($title)) {
            $this->error('广告标题不能为空！');
        }
        if (empty($type)) {
            $this->error('请选择广告类型！');
        }
        if (empty($pic)) {
            $this->error('请上传广告图片！');
        }
        if (empty($content) && $type == 2) {
            $this->error('请输入广告内容！');
        }
        $data = array(
            'title'   => $title,
            'type'    => $type,
            'pic'     => $pic,
            'content' => $content,
            'sort'    => $sort,
        );
        if ($id > 0) {
            $data['id'] = $id;
            $res        = M('advert')->save($data);
        } else {
            $data['add_time'] = date('Y-m-d H:i:s');
            $res              = M('advert')->add($data);
        }
        if ($res !== false) {
            $this->success('保存成功');
        } else {
            $this->error('保存失败！');
        }
    }

    /**
     * 更新广告状态
     */
    public function setStatus() {
        if (!IS_AJAX) {
            $this->error('非法请求！');
        }
        $id   = I('get.id', 0, 'int');
        $info = M('advert')->find($id);
        if (empty($id) || empty($info)) {
            $this->error('广告信息不存在！');
        }
        $status = $info['status'] == 1 ? 2 : 1;
        $msg    = $status == 1 ? '启用' : '禁用';
        $res    = M('advert')->save(array('status' => $status, 'id' => $id));
        if ($res) {
            $this->success($msg . '成功');
        } else {
            $this->error($msg . '失败！');
        }
    }

    /**
     * 删除广告
     */
    public function delete() {
        if (!IS_AJAX) {
            $this->error('非法请求！');
        }
        $id   = I('get.id', 0, 'int');
        $info = M('advert')->find($id);
        if (empty($id) || empty($info)) {
            $this->error('广告信息不存在！');
        }
        if ($info['status'] == 1) {
            $this->error('不能删除正在启用的广告');
        }
        $res = M('advert')->delete($id);
        if ($res !== false) {
            $this->_delOss($info['pic']);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }

}