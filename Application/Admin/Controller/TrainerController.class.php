<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/2
 * Time: 17:29
 */

namespace Admin\Controller;

/**
 * 健康管理员
 * Class TrainerController
 *
 * @package Admin\Controller
 */
class TrainerController extends CommonController {

    /**
     * 健康管理员列表
     */
    public function index() {
        if (IS_AJAX) {
            $mobile    = I('get.mobile', '', 'trim');
            $real_name = I('get.real_name', '', 'trim');
            $status    = I('get.status', 0, 'int');
            $page      = I('get.page', 1, 'int');
            $limit     = I('get.limit', 10, 'int');
            $model     = M('trainer');
            $where     = array();
            if ($mobile) {
                $where['mobile'] = $mobile;
            }
            if ($real_name) {
                $where['real_name'] = $real_name;
            }
            if ($status) {
                $where['status'] = $status;
            }
            $count    = $model->where($where)->count('id');
            $data     = $model->where($where)->page($page)->limit($limit)->order('id desc')->select();
            $type_arr = array(1 => '男', 2 => '女');
            foreach ($data as &$val) {
                $val['sex_view'] = $type_arr[$val['sex']];
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
        $info = M('trainer')->find($id);
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
        $mobile    = I('post.mobile', '', 'trim');
        $password  = I('post.password', '', 'trim');
        $real_name = I('post.real_name', '', 'trim');
        $avatar    = I('post.avatar', '', 'trim');
        $age       = I('post.age', 0, 'int');
        $sex       = I('post.sex', 0, 'int');
        $id        = I('post.id', 0, 'int');
        if (empty($mobile)) {
            $this->error('手机号码不能为空！');
        }
        if (!is_mobile($mobile)) {
            $this->error('手机号码格式不正确！');
        }
        $count = M('trainer')->where(array('mobile' => $mobile))->count('id');
        if ($id > 0) {
            if ($count > 1) {
                $this->error('手机号码已存在！');
            }
        } else {
            if ($count > 0) {
                $this->error('手机号码已存在！');
            }
        }
        if ($id == 0) {
            if (empty($password)) {
                $this->error('登录密码不能为空！');
            }
            if (strlen($password) < 6 || strlen($password) > 18) {
                $this->error('登录密码必须在6-18位！');
            }
        } else {
            if ($password) {
                if (strlen($password) < 6 || strlen($password) > 18) {
                    $this->error('登录密码必须在6-18位！');
                }
            }
        }
        if (empty($real_name)) {
            $this->error('真实姓名不能为空！');
        }
        if (empty($avatar)) {
            $this->error('请上传健康管理员图像！');
        }
        if (empty($age)) {
            $this->error('年龄不能为空！');
        }
        if (empty($sex)) {
            $this->error('请选择健康管理员性别！');
        }
        $data = array(
            'mobile'    => $mobile,
            'real_name' => $real_name,
            'avatar'    => $avatar,
            'age'       => $age,
            'sex'       => $sex,
        );
        if ($id > 0) {
            $data['id'] = $id;
            if ($password) {
                $data['password'] = encrypt_pwd(md5($password));
            }
            $info = M('trainer')->where(array('mobile' => $mobile))->find();
            S($info['token'], $info);
            $res = M('trainer')->save($data);
        } else {
            $data['password'] = encrypt_pwd(md5($password));
            $data['token']    = encrypt_pwd($mobile);
            $data['add_time'] = date('Y-m-d H:i:s');
            $res              = M('trainer')->add($data);
        }
        if ($res !== false) {
            $this->success('保存成功');
        } else {
            $this->error('保存失败！');
        }
    }

    /**
     * 更新健康管理员状态
     */
    public function setStatus() {
        if (!IS_AJAX) {
            $this->error('非法请求！');
        }
        $id   = I('get.id', 0, 'int');
        $info = M('trainer')->find($id);
        if (empty($id) || empty($info)) {
            $this->error('健康管理员信息不存在！');
        }
        $status = $info['status'] == 1 ? 2 : 1;
        $msg    = $status == 1 ? '启用' : '禁用';
        $token  = $status == 1 ? encrypt_pwd($info['mobile']) : '';
        $res    = M('trainer')->save(array('status' => $status, 'id' => $id, 'token' => $token));
        if ($res) {
            $this->success($msg . '成功');
        } else {
            $this->error($msg . '失败！');
        }
    }

}