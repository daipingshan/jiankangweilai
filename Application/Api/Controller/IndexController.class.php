<?php
/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/7/4
 * Time: 17:28
 */

namespace Api\Controller;

/**
 * Class IndexController
 *
 * @package Api\Controller
 */
class IndexController extends CommonController {

    /**
     * app首页
     */
    public function index() {
        $advert_data    = $this->_getAdvert();
        $custom         = C('CUSTOM_SERVICE');
        $caregiver_baby = $this->_getCaregiverBaby();
        $data           = array('advert_data' => $advert_data, 'custom' => $custom, 'caregiver_baby' => $caregiver_baby);
        $this->output('ok', 'success', $data);
    }

    /**
     * 获取广告
     */
    
    protected function _getAdvert() {
        $where = array('status' => 1);
        return M('advert')->where($where)->select();
    }

    /**
     * 获取养育人-宝宝
     */
    protected function _getCaregiverBaby() {
        $where = array('trainer_id' => $this->user_id);
        $data  = M('caregiver_baby')->field('*,id as baby_id,id as caregiver_baby_id')->where($where)->select();
        foreach ($data as &$val) {
            $val['train_last_time'] = M('train')->where(array('caregiver_baby_id' => $val['id']))->order('add_time desc')->getField('add_time') ? : '';
            $val['exam_last_score'] = M('exam')->where(array('caregiver_baby_id' => $val['id']))->order('add_time desc')->getField('score') ? : '';
        }
        return $data;
    }

}