<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/6
 * Time: 13:55
 */

namespace Api\Controller;


class BabyController extends CommonController {

    /**
     * 更新宝宝信息
     */
    public function updateDetail() {
        $baby_id = I('post.baby_id', 0, 'int');
        $count   = $this->_checkBaby($baby_id);
        if ($count == 0) {
            $this->output('该健康管理员下不存在改宝宝信息！');
        }
        $baby_status       = I('post.baby_status', '', 'trim');
        $baby_name         = I('post.baby_name', '', 'trim');
        $baby_sex          = I('post.baby_sex', 0, 'int');
        $baby_avatar       = I('post.baby_avatar', '', 'trim');
        $baby_birthday     = I('post.baby_birthday', '', 'trim');
        $baby_anemia_value = I('post.baby_anemia_value', '', 'trim');
        if ($baby_status == '') {
            $this->output('宝宝出生状态不能为空！');
        }
        if ($baby_status == 1) {
            if (empty($baby_name)) {
                $this->output('宝宝姓名不能为空！');
            }
            if (empty($baby_sex)) {
                $this->output('宝宝性别不能为空！');
            }
            if (empty($baby_avatar)) {
                $this->output('宝宝图像不能为空！');
            }
            if (empty($baby_birthday)) {
                $this->output('宝宝出生日期不能为空！');
            }
        } else {
            if (empty($baby_birthday)) {
                $this->output('宝宝预产期不能为空！');
            }
        }
        $data = array(
            'id'                => $baby_id,
            'baby_status'       => $baby_status,
            'baby_name'         => $baby_name,
            'baby_sex'          => $baby_sex,
            'baby_avatar'       => $baby_avatar,
            'baby_birthday'     => $baby_birthday,
            'baby_birthday_day' => intval(date('d', strtotime($baby_birthday))),
            'baby_anemia_value' => $baby_anemia_value
        );
        $res  = M('caregiver_baby')->save($data);
        if ($res !== false) {
            $this->output('更新成功', 'success');
        } else {
            $this->output('更新失败');
        }
    }

    /**
     * 添加宝宝成长记录
     */
    public function addGrowInfo() {
        $baby_id = I('post.baby_id', 0, 'int');
        $count   = $this->_checkBaby($baby_id);
        if ($count == 0) {
            $this->output('该健康管理员下不存在改宝宝信息！');
        }
        $height        = I('post.height', '', 'trim');
        $weight        = I('post.weight', '', 'trim');
        $vaccine       = I('post.vaccine', '', 'trim');
        $nutrition_num = I('post.nutrition_num', 0, 'int');
        $add_time      = I('post.add_time', '', 'trim');
        if (empty($height)) {
            $this->output('宝宝身高不能为空！');
        }
        if (empty($weight)) {
            $this->output('宝宝体重不能为空！');
        }
        if (empty($vaccine)) {
            $this->output('宝宝已打过的疫苗不能为空！');
        }
        if (empty($nutrition_num)) {
            $this->output('宝宝已吃过的营养包数不能为空！');
        }
        if (empty($add_time)) {
            $this->output('记录日期不能为空！');
        }
        $is_have = M('baby_grow')->where(array('baby_id' => $baby_id, 'add_time' => $add_time))->count('id');
        if ($is_have > 0) {
            $this->output('该宝宝本月成长记录已记录，不能重复记录！');
        }
        $data = array(
            'baby_id'       => $baby_id,
            'height'        => $height,
            'weight'        => $weight,
            'vaccine'       => $vaccine,
            'nutrition_num' => $nutrition_num,
            'add_time'      => $add_time
        );
        $res  = M('baby_grow')->add($data);
        if ($res) {
            $this->output('记录成功', 'success');
        } else {
            $this->output('记录失败！');
        }
    }

    /**
     * 查看成长记录
     */
    public function getGrowInfo() {
        $baby_id = I('post.baby_id', 0, 'int');
        $where   = array('baby_id' => $baby_id);
        $data    = M('baby_grow')->where($where)->select();
        $this->output('ok', 'success', $data);
    }

}