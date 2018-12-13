<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/1/17
 * Time: 17:49
 */

namespace Api\Controller;

/**
 * 公共接口
 * Class PublicController
 *
 * @package Api\Controller
 */
class PublicController extends CommonController {

    /**
     * 检测用户是否需要登录
     *
     * @var bool
     */
    protected $checkUser = false;


    /**
     * 用户登录
     */
    public function login() {
        $mobile   = I('request.mobile', '', 'trim');
        $password = I('request.password', '', 'trim');
        if (empty($mobile)) {
            $this->output('手机号码不能为空！');
        }
        if (empty($password)) {
            $this->output('登录密码不能为空！');
        }
        if (is_mobile($mobile) === false) {
            $this->output('手机号码格式不正确');
        }
        $user = M('trainer')->where(array('mobile' => $mobile))->find();
        if (empty($user)) {
            $this->output('手机号码尚未注册，请注册后登录！');
        }
        if ($user['password'] != encrypt_pwd($password)) {
            $this->output('密码错误！');
        }
        if ($user['status'] == 2) {
            $this->output('账号已禁用！');
        }
        $token = $user['token'];
        S($user['token'], $user);
        $this->output('ok', 'success', array('token' => $token));
    }

    /***
     * 检测更新
     */
    public function checkUpdate() {
        $app_ver     = I('get.ver', '', 'trim');
        $config      = C('APP_UPDATE');
        $service_ver = $config['version'] ? : '';
        $is_upgrade  = 'N';
        if ($app_ver && strcmp($service_ver, $app_ver) > 0) {
            $is_upgrade = 'Y';
        }
        $data = array(
            'version'      => $service_ver,
            'is_force'     => $config['is_force'] == 1 ? 'Y' : 'N',
            'is_upgrade'   => $is_upgrade,
            'description'  => $config['description'] ? : '',
            'download_url' => $config['down_url'] ? : '',
        );
        $this->output('ok', 'success', $data);
    }

}