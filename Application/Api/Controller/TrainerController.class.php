<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/6
 * Time: 10:37
 */

namespace Api\Controller;

/**
 * Class TrainerController
 *
 * @package Api\Controller
 */
class TrainerController extends CommonController {

    /**
     * 健康管理员信息
     */
    public function index() {
        $token = I('request.token', '', 'trim');
        $data  = S($token);
        $this->output('ok', 'success', $data);
    }

    /**
     * 修改密码
     */
    public function updatePassword() {
        $old_password = I('request.old_password', '', 'trim');
        $new_password = I('request.new_password', '', 'trim');
        if (empty($old_password)) {
            $this->output('原始密码不能为空！');
        }
        if (empty($new_password)) {
            $this->output('新密码不能为空！');
        }
        $db_password = M('trainer')->getFieldById($this->user_id, 'password');
        if ($db_password != $old_password) {
            $this->output('原始密码错误！');
        }
        if (strlen($new_password) < 6 || strlen($new_password) > 18) {
            $this->output('密码长度必须在6-18位!');
        }
        if ($old_password == $new_password) {
            $this->output('新密码不能与原始密码相同！');
        }
        $res = M('trainer')->where(array('id' => $this->user_id))->save(array('password' => encrypt_pwd($new_password)));
        if ($res) {
            $this->output('修改成功', 'success');
        } else {
            $this->output('修改失败！');
        }
    }

}