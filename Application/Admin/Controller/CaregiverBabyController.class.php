<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/3
 * Time: 8:53
 */

namespace Admin\Controller;

/**
 * 养育人-宝宝
 * Class CaregiverBabyController
 *
 * @package Admin\Controller
 */
class CaregiverBabyController extends CommonController {

    /**
     * 养育人列表
     */
    public function index() {
        if (IS_AJAX) {
            $trainer_id       = I('get.trainer_id', '', 'trim');
            $caregiver_name   = I('get.caregiver_name', '', 'trim');
            $caregiver_mobile = I('get.caregiver_mobile', '', 'trim');
            $baby_name        = I('get.baby_name', '', 'trim');
            $page             = I('get.page', 1, 'int');
            $limit            = I('get.limit', 10, 'int');
            $model            = M('caregiver_baby');
            $where            = array();
            if ($trainer_id) {
                $where['c.trainer_id'] = $trainer_id;
            }
            if ($caregiver_name) {
                $where['c.mobile'] = $caregiver_name;
            }
            if ($caregiver_mobile) {
                $where['c.real_name'] = $caregiver_mobile;
            }
            if ($baby_name) {
                $where['c.baby_name'] = $baby_name;
            }
            $count = $model->alias('c')->where($where)->count('id');
            $data  = $model->alias('c')->join('left join trainer t ON t.id=c.trainer_id')->field('c.*,t.real_name,t.mobile')->where($where)->page($page)->limit($limit)->order('id desc')->select();
            foreach ($data as &$val) {
                $val['caregiver_age'] = date('Y') - date('Y', strtotime($val['caregiver_birthday']));
            }
            $this->output($data, $count);
        } else {
            $trainer_data = $this->_getTrainerData();
            $this->assign('trainer_data', $trainer_data);
            $this->display();
        }
    }

    /**
     * 添加养育人
     */
    public function add() {
        $trainer_data = $this->_getTrainerData();
        $relation     = C('caregiver_relation');
        $this->assign('relation', explode(',', $relation));
        $this->assign('trainer_data', $trainer_data);
        $this->display();
    }

    /**
     * 修改养育人
     */
    public function update() {
        $id           = I('get.id', 0, 'int');
        $info         = M('caregiver_baby')->find($id);
        $trainer_data = $this->_getTrainerData();
        $relation     = C('caregiver_relation');
        $this->assign('relation', explode(',', $relation));
        $this->assign('trainer_data', $trainer_data);
        $this->assign('info', $info);
        $this->display();
    }

    /**
     * 保存养育人
     */
    public function save() {
        if (!IS_AJAX) {
            $this->error('非法请求！');
        }
        $trainer_id         = I('post.trainer_id', 0, 'int');
        $caregiver_name     = I('post.caregiver_name', '', 'trim');
        $caregiver_avatar   = I('post.caregiver_avatar', '', 'trim');
        $caregiver_mobile   = I('post.caregiver_mobile', '', 'trim');
        $caregiver_birthday = I('post.caregiver_birthday', '', 'trim');
        $address            = I('post.address', '', 'trim');
        $relation           = I('post.relation', '', 'trim');
        $baby_status        = I('post.baby_status', 0, 'int');
        $baby_name          = I('post.baby_name', '', 'trim');
        $baby_anemia_value  = I('post.baby_anemia_value', 0, 'int');
        $baby_sex           = I('post.baby_sex', 0, 'int');
        $baby_avatar        = I('post.baby_avatar', '', 'trim');
        $baby_birthday      = I('post.baby_birthday', '', 'trim');
        $id                 = I('post.id', 0, 'int');
        if (empty($trainer_id)) {
            $this->error('请选择健康管理员！');
        }
        if (empty($caregiver_name)) {
            $this->error('养育人姓名不能为空！');
        }
        if (empty($caregiver_avatar)) {
            $this->error('请上传养育人头像！');
        }
        if (empty($caregiver_mobile)) {
            $this->error('养育人手机号码不能为空！');
        }
        if (!is_mobile($caregiver_mobile)) {
            $this->error('养育人手机号码格式不正确！');
        }
        if (empty($caregiver_birthday)) {
            $this->error('养育人出生日期不能为空！');
        }
        if (empty($address)) {
            $this->error('地址不能为空！');
        }
        if (empty($relation)) {
            $this->error('请选择养育人与宝宝关系！');
        }
        if ($baby_status == 1) {
            if (empty($baby_name)) {
                $this->error('宝宝姓名不能为空！');
            }
            if (empty($baby_sex)) {
                $this->error('请选择宝宝性别！');
            }
        }
        if (empty($baby_birthday)) {
            $this->error('宝宝出生日期不能为空！');
        }
        if ($baby_status == 0 && $id == 0) {
            $baby_sex = 0;
        }
        $data = array(
            'trainer_id'         => $trainer_id,
            'caregiver_avatar'   => $caregiver_avatar,
            'caregiver_name'     => $caregiver_name,
            'caregiver_mobile'   => $caregiver_mobile,
            'caregiver_birthday' => $caregiver_birthday,
            'relation'           => $relation,
            'address'            => $address,
            'baby_status'        => $baby_status,
            'baby_name'          => $baby_name,
            'baby_sex'           => $baby_sex,
            'baby_avatar'        => $baby_avatar,
            'baby_anemia_value'  => $baby_anemia_value,
            'baby_birthday'      => $baby_birthday,
            'baby_birthday_day'  => intval(date('d', strtotime($baby_birthday))),
        );
        if ($id > 0) {
            $data['id'] = $id;
            if ($baby_status == 0) {
                unset($data['baby_status']);
            }
            $res = M('caregiver_baby')->save($data);
        } else {
            $res = M('caregiver_baby')->add($data);
        }
        if ($res !== false) {
            $this->success('保存成功');
        } else {
            $this->error('保存失败！');
        }
    }

    /**
     * 查看宝宝成长记录
     */
    public function babyGrow() {
        $id   = I('get.id', 0, 'int');
        $data = M('baby_grow')->where(array('baby_id' => $id))->order('id desc')->select();
        $this->assign('data', $data);
        $this->display();
    }

}