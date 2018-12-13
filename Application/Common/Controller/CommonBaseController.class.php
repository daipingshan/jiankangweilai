<?php

/**
 * Created by PhpStorm.
 * User: daipingshan
 * Date: 2018/5/2
 * Time: 11:15
 */

namespace Common\Controller;

use Think\Controller;
use Think\Page;
use Common\Org\AliYunOss as OSS;

/**
 * Class CommonController
 *
 * @package Common\Controller
 */
class CommonBaseController extends Controller {

    /**
     * @var int
     */
    protected $limit = 20;

    /**
     * CommonBaseController constructor.
     */
    public function __construct() {
        parent::__construct();
        header("Content-type: text/html; charset=utf-8");
    }

    /**
     * 上传项目图片
     */
    public function uploadImg() {
        $Object = new OSS();
        $data   = $Object->uploadObject();
        if ($data['code'] == 1) {
            $res = array(
                "state"   => "SUCCESS",
                "db_url"  => $data['url'],
                "url"     => get_img_url($data['url']),
                "message" => '上传成功',
                "error"   => 0,
            );
        } else {
            $res = array(
                "state"   => 'ERROR',
                "error"   => 1,
                "url"     => '',
                'db_url'  => '',
                "message" => $data['info'],
            );
        }
        ob_clean();
        die(json_encode($res));
    }

    /**
     * 上传项目图片
     */
    public function uploadEditImg() {
        $Object = new OSS();
        $data   = $Object->uploadObject();
        if ($data['code'] == 1) {
            $res = array(
                "code" => 0,
                "msg"  => '上传成功',
                "data" => array('src' => get_img_url($data['url']), 'title' => get_img_url($data['url'])),
            );
        } else {
            $res = array(
                "code" => -1,
                "msg"  => $data['info'],
            );
        }
        ob_clean();
        die(json_encode($res));
    }

    /**
     * 删除阿里云数据
     *
     * @param $path
     */
    protected function _delOss($path) {
        $path_info = parse_url($path);
        $oss       = new OSS();
        $oss->deleteObject(substr($path_info['path'], 1));
    }

    /**
     * @param $totalRows
     * @param $listRows
     * @param array $map
     * @param int $rollPage
     * @return Page
     */
    protected function pages($totalRows, $listRows, $map = array(), $rollPage = 5) {
        $Page = new Page($totalRows, $listRows, '', MODULE_NAME . '/' . ACTION_NAME);
        if ($map && IS_POST) {
            foreach ($map as $key => $val) {
                $val             = urlencode($val);
                $Page->parameter .= "$key=" . urlencode($val) . '&';
            }
        }
        if ($rollPage > 0) {
            $Page->rollPage = $rollPage;
        }
        $Page->setConfig('header', '条信息');
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('last', '末页');
        $Page->setConfig(
            'theme', '<div class="layui-box layui-laypage layui-laypage-default" id="layui-laypage-1"><span>当前页' . $listRows . '条数据 总%TOTAL_ROW% %HEADER%</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE%</div>'
        );
        return $Page;
    }

    /**
     * @param $url
     * @param array $params
     * @param $cookie
     * @return bool|mixed
     */
    protected function _get($url, $params = array(), $cookie = '') {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== false) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1);
        }
        $header = array(
            'Accept:application/json, text/javascript, */*; q=0.01',
            'Content-Type:application/x-www-form-urlencoded; charset=UTF-8',
            'X-Requested-With:XMLHttpRequest',
        );
        if ($cookie) {
            $header[] = "cookie:{$cookie}";
        }
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, $header);
        if (!empty($params)) {
            if (strpos($url, '?') !== false) {
                $url .= "&" . http_build_query($params);
            } else {
                $url .= "?" . http_build_query($params);
            }
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_TIMEOUT, 5);
        $sContent = curl_exec($oCurl);
        $aStatus  = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }

    /**
     * @param string $url
     * @param array $params
     * @param $cookie
     * @return bool|mixed
     */
    protected function _post($url = '', $params = array(), $cookie = '') {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== false) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1);
        }
        $header = array(
            'Accept:application/json, text/javascript, */*; q=0.01',
            'Content-Type:application/x-www-form-urlencoded; charset=UTF-8',
            'X-Requested-With:XMLHttpRequest',
        );
        if ($cookie) {
            $header[] = "cookie:{$cookie}";
        }
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POST, 1);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($oCurl, CURLOPT_TIMEOUT, 5);
        $sContent = curl_exec($oCurl);
        $aStatus  = curl_getinfo($oCurl);

        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }

    /**
     * @param string $url
     * @param array $params
     * @param $cookie
     * @return bool|mixed
     */
    protected function _file($url = '', $params = array(), $cookie = '') {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== false) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1);
        }
        $header = array(
            'Accept:application/json, text/javascript, */*; q=0.01',
            'X-Requested-With:XMLHttpRequest',
        );
        if ($cookie) {
            $header[] = "cookie:{$cookie}";
        }
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POST, 1);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($oCurl, CURLOPT_TIMEOUT, 5);
        $sContent = curl_exec($oCurl);
        $aStatus  = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }

    /**
     * 二维数组排序
     *
     * @param $data
     * @param $sort_order_field
     * @return mixed
     */
    protected function _arraySort($data, $sort_order_field) {
        if (!$data) {
            return array();
        }
        foreach ($data as $val) {
            $key_arrays[] = $val[$sort_order_field];
        }
        array_multisort($key_arrays, SORT_ASC, SORT_NUMERIC, $data);
        return $data;
    }


    /**
     * @param $filename
     * @param $data
     */
    protected function _addLogs($filename, $data) {
        $path = "/logs/" . date('Y-m-d');
        if (!is_dir($path)) {
            @mkdir($path);
        }
        $path = $path . "/" . $filename;
        if (is_array($data)) {
            file_put_contents($path, var_export($data, true) . "\r\n", FILE_APPEND);
        } else {
            file_put_contents($path, $data . "\r\n", FILE_APPEND);
        }
    }

}